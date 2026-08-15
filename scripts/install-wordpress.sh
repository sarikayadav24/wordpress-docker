#!/bin/sh

echo "Waiting for database to be ready..."
until mariadb-admin ping -h db -u "${WORDPRESS_DB_USER}" -p"${WORDPRESS_DB_PASSWORD}" --silent --skip-ssl 2>/dev/null; do
  echo "Retrying in 3s..."
  sleep 3
done

echo "Checking if WordPress is already installed..."
if wp core is-installed --allow-root --path=/var/www/html 2>/dev/null; then
  echo "Already installed. Skipping."
  exit 0
fi

echo "Running WordPress installation..."
wp core install \
  --url="${WP_URL}" \
  --title="${WP_TITLE}" \
  --admin_user="${WP_ADMIN_USER}" \
  --admin_password="${WP_ADMIN_PASSWORD}" \
  --admin_email="${WP_ADMIN_EMAIL}" \
  --skip-email \
  --allow-root \
  --path=/var/www/html

echo "Activating theme..."
wp theme activate sarika-portfolio --allow-root --path=/var/www/html

echo "Activating plugins..."
wp plugin activate sarika-booking-system sarika-contact-form sarika-portfolio-manager --allow-root --path=/var/www/html

echo "Installing and activating WooCommerce..."
wp plugin install woocommerce --activate --allow-root --path=/var/www/html

echo "Activating WooCommerce dependent plugins..."
wp plugin activate sarika-woo-tweaks --allow-root --path=/var/www/html

echo "Setting permalinks..."
wp rewrite structure '/%postname%/' --allow-root --path=/var/www/html
wp rewrite flush --allow-root --path=/var/www/html

echo "Done! WordPress is ready."

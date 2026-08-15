#!/bin/sh

echo "Waiting for database to be ready..."
until wp db check --allow-root 2>/dev/null; do
  echo "Retrying in 3s..."
  sleep 3
done

echo "Checking if WordPress is already installed..."
if wp core is-installed --allow-root 2>/dev/null; then
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
  --allow-root

echo "Activating theme..."
wp theme activate sarika-portfolio --allow-root

echo "Activating plugins..."
wp plugin activate sarika-booking-system sarika-contact-form sarika-portfolio-manager sarika-woo-tweaks --allow-root

echo "Setting permalinks..."
wp rewrite structure '/%postname%/' --allow-root
wp rewrite flush --allow-root

echo "Done! WordPress is ready."

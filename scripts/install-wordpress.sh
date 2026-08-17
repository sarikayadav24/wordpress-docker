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

echo "Setting up WooCommerce pages..."
wp wc tool run install_pages --user=admin --allow-root --path=/var/www/html

echo "Configuring WooCommerce store..."
wp option update woocommerce_currency "GBP" --allow-root --path=/var/www/html
wp option update woocommerce_default_country "GB" --allow-root --path=/var/www/html
wp option update woocommerce_onboarding_profile '{"completed":true}' --format=json --allow-root --path=/var/www/html

echo "Creating pages..."
wp post create \
  --post_type=page \
  --post_title="Book Now" \
  --post_status=publish \
  --post_content="[sarika_booking]" \
  --allow-root \
  --path=/var/www/html

wp post create \
  --post_type=page \
  --post_title="Contact" \
  --post_status=publish \
  --post_content="[sarika_contact_form]" \
  --allow-root \
  --path=/var/www/html

echo "Creating sample products..."
wp wc product create \
  --name="Web Design Package" \
  --type=simple \
  --regular_price=299.99 \
  --description="Professional web design service including up to 5 pages." \
  --status=publish \
  --user=admin \
  --allow-root \
  --path=/var/www/html

wp wc product create \
  --name="SEO Consultation" \
  --type=simple \
  --regular_price=99.99 \
  --description="One hour SEO consultation and audit for your website." \
  --status=publish \
  --user=admin \
  --allow-root \
  --path=/var/www/html

wp wc product create \
  --name="Monthly Maintenance" \
  --type=simple \
  --regular_price=49.99 \
  --description="Monthly website maintenance and support package." \
  --status=publish \
  --user=admin \
  --allow-root \
  --path=/var/www/html

echo "Setting up navigation menu..."
wp menu create "Primary Menu" --allow-root --path=/var/www/html

MENU_ID=$(wp menu list --field=term_id --name="Primary Menu" --allow-root --path=/var/www/html)

wp menu item add-post $MENU_ID $(wp post list --post_type=page --pagename="shop" --field=ID --allow-root --path=/var/www/html) --allow-root --path=/var/www/html

wp menu item add-post $MENU_ID $(wp post list --post_type=page --pagename="book-now" --field=ID --allow-root --path=/var/www/html) --allow-root --path=/var/www/html

wp menu location assign $MENU_ID primary --allow-root --path=/var/www/html


echo "Done! WordPress is ready."

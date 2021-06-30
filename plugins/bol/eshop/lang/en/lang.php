<?php return [
    'plugin' => [
        'name' => 'eShop',
        'description' => 'A plugin for e-commerce and inventory management system.',
    ],
    'product' => [
        'id' => 'ID',
        'title' => 'Title',
        'slug' => 'Slug',
        'photos' => 'Photos',
        'tab_basic' => 'Basic',
        'short_description' => 'Short Description',
        'description' => 'Description',
        'tab_category' => 'Category',
        'select_categories' => 'Select Categories',
        'price' => 'Price',
        'tab_price' => 'Price',
        'discount' => 'Discount',
        'discount_type' => 'Discount Type',
        'video_url' => 'Video url',
        'discount_start' => 'Discount Start Date Time',
        'discount_end' => 'Discount End Date Time',
        'brand' => 'Brand',
        'tab_others' => 'Others',
        'product_type' => 'Product Type',
        'external_download_link' => 'External Download Link',
        'download_from_site' => 'Download From Site',
        'weight' => 'Weight',
        'unit' => 'Unit',
        'set_color_variation' => 'Set Color Variation',
        'select_color_variation' => 'Select Color Variation',
        'add_new_color_variation' => 'Add New Color Variation',
        'color_variation_comment' => 'Set Price If Color Variation has different price.',
        'set_size_variation' => 'Set Size Variation',
        'add_new_size_variation' => 'Add New Size Variation',
        'size_label' => 'Size Label',
        'size_variation_comment' => 'Set Price If Size Variation has different price.',
        'is_published' => 'Is Published?',
        'is_featured' => 'Is Featured?',
        'published_at' => 'Published at',
        'tab_seo' => 'SEO',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'delete_success' => 'Delete Success',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'page_view' => 'Page View',
        'view' => 'View',
        'type' => 'Type',
        'created_by' => 'Created by',
        'select_a_brand' => 'Select a Brand',
        'select_a_unit' => 'Select a Unit',
    ],
    'categories' => [
        'list_title' => 'Manage the blog categories',
        'new_category' => 'New category',
        'uncategorized' => 'Uncategorized'
    ],
    'category' => [
        'id' => 'ID',
        'name' => 'Name',
        'name_placeholder' => 'New category name',
        'description' => 'Description',
        'slug' => 'Slug',
        'slug_placeholder' => 'new-category-slug',
        'posts' => 'Posts',
        'delete_confirm' => 'Delete this category?',
        'delete_success' => 'Successfully deleted those categories.',
        'return_to_categories' => 'Return to the blog category list',
        'reorder' => 'Reorder Categories',
        'photo' => 'Photo',
        'details' => 'Details',
        'tab_seo' => 'SEO',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'product_count' => 'Product Count',
        'is_featured' => 'Is Featured?',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'permission' => [
        'manage_products' => 'Manage Products',
        'access_publish' => 'Access Publish',
        'access_other_products' => 'Access Other Products',
        'manage_categories' => 'Manage Categories',
        'manage_brands' => 'Manage Brands',
        'manage_orders' => 'Manage Orders',
        'manage_order_statuses' => 'Manage Order Statuses',
        'manage_basic_settings' => 'Manage Basic Settings',
        'manage_units' => 'Manage Units',
        'manage_currencies' => 'Manage Currencies',
        'manage_shipping_methods' => 'Manage Shipping Methods',
        'manage_payment_methods' => 'Manage Payment Methods',
    ],
    'brand' => [
        'id' => 'Id',
        'name' => 'Name',
        'slug' => 'Slug',
        'description' => 'Description',
        'status' => 'Status',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'logo' => 'Logo',
        'sort_order' => 'Sort Order',
    ],
    'unit' => [
        'name' => 'Name',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'currency' => [
        'id' => 'ID',
        'name' => 'Name',
        'code' => 'Code',
        'symbol' => 'Symbol',
        'sort_order' => 'Sort Order',
        'is_active' => 'Is Active?',
        'is_default' => 'Is Default?',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'order_status' => [
        'id' => 'ID',
        'name' => 'Name',
        'color' => 'Color',
        'sort_order' => 'Sort Order',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'payment_method' => [
        'id' => 'ID',
        'name' => 'Name',
        'code' => 'Code',
        'sort_order' => 'Sort Order',
        'is_active' => 'Is Active?',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'shipping_method' => [
        'id' => 'ID',
        'name' => 'Name',
        'code' => 'Code',
        'price' => 'Price',
        'sort_order' => 'Sort Order',
        'is_active' => 'Is Active?',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'menu' => [
        'products' => 'Products',
        'categories' => 'Categories',
        'brands' => 'Brands',
    ],
    'menuitem' => [
        'shop_category' => 'Shop Category',
        'all_shop_categories' => 'All Shop Categories',
        'shop_product' => 'Shop Product',
        'all_shop_products' => 'All Shop Products',
        'category_shop_products' => 'Category Shop Products',
    ],
    'sorting' => [
        'title_asc' => 'Title (ascending)',
        'title_desc' => 'Title (descending)',
        'created_asc' => 'Created (ascending)',
        'created_desc' => 'Created (descending)',
        'updated_asc' => 'Updated (ascending)',
        'updated_desc' => 'Updated (descending)',
        'published_asc' => 'Published (ascending)',
        'published_desc' => 'Published (descending)',
        'random' => 'Random'
    ],
    'settings' => [
        'eshop' => 'Basic Settings',
        'eshop_description' => 'Manage basic settings for eShop.',
        'tab_eshop' => 'eShop Settings',
        'currencies' => 'Currencies',
        'currency_description' => 'Manage currencies for product & orders.',
        'units' => 'Units',
        'units_description' => 'Manage Units for products.',
        'payment_methods' => 'Payment Methods',
        'payment_methods_description' => 'Manage Payment Methods for orders.',
        'shipping_methods' => 'Shipping Method',
        'shipping_methods_description' => 'Manage Shipping Methods for orders.',
        'order_status' => 'Order Status',
        'order_statuses_description' => 'Manage Order Statuses for orders.',
    ],
];
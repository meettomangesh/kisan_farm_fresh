<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'region'           => [
        'title'          => 'Regions',
        'title_singular' => 'Region',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'region_name'              => 'Name',
            'region_name_helper'       => '',
            'pin_codes'        => 'Pin Codes',
            'pin_codes_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',

        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'first_name'               => 'First name',
            'first_name_helper'        => '',
            'last_name'                => 'Last name',
            'last_name_helper'         => '',
            'mobile_number'            => 'Mobile Number',
            'mobile_number_helper'     => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'deliveryboy'           => [
        'title'          => 'Delivery Boys',
        'title_singular' => 'Delivery Boy',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'first_name'               => 'First name',
            'first_name_helper'        => '',
            'last_name'                => 'Last name',
            'last_name_helper'         => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'mobile_number'            => 'Mobile Number',
            'mobile_number_helper'     => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'regions'                  => 'Regions',
            'regions_helper'             => '',
            'aadhar_number'            => 'Aadhar number',
            'aadhar_photo'            => 'Aadhar photo',
            'pan_number'            => 'PAN number',
            'pan_photo'            => 'PAN photo',
            'license_card_photo'    => 'License photo',
            'license_number' => 'License number',
            'vehicle_number'            => 'Vehicle number',
            'rc_book_photo'            => 'RC book photo',
            'user_photo'               => 'User photo',
            'bank_name'                => 'Bank name',
            'account_number'           => 'Account number',
            'ifsc_code'                => 'IFSC code',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'status'                => 'Status',
            'kyc_verified'                => 'KYC verified',
            'submitted' => 'Submitted',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'new' => 'New',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
        ],
    ],
    'customers'           => [
        'title'          => 'Customers',
        'title_singular' => 'Customer',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'first_name'               => 'First name',
            'first_name_helper'        => '',
            'last_name'                => 'Last name',
            'last_name_helper'         => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'mobile_number'            => 'Mobile Number',
            'mobile_number_helper'     => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'regions'                  => 'Regions',
            'regions_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',

        ],
    ],
    'country'        => [
        'title'          => 'Countries',
        'title_singular' => 'Country',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'short_code'        => 'Short Code',
            'short_code_helper' => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'city'           => [
        'title'          => 'Cities',
        'title_singular' => 'City',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'country'           => 'Country',
            'state'             => 'State',
            'country_helper'    => '',
            'state_helper'    => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'state'           => [
        'title'          => 'States',
        'title_singular' => 'State',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'country'           => 'Country',
            'country_helper'    => '',
            'state'             => 'State',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'pin_code'           => [
        'title'          => 'Pin Codes',
        'title_singular' => 'Pin Code',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'pin_code'              => 'Pin Code',
            'name_helper'       => '',
            'country'           => 'Country',
            'state'             => 'State',
            'city'              => 'City',
            'country_helper'    => '',
            'state_helper'      => '',
            'city_helper'       => '',
            'pin_code'          => 'Pin Code',
            'pin_code_helper'   => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'territories'           => [
        'title'          => 'Territories',
        'title_singular' => 'Territory',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'country'           => 'Country',
            'country_helper'    => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],

    'productManagement' => [
        'title'          => 'Product Management',
        'title_singular' => 'Product Management',
    ],
    'product'        => [
        'title'          => 'Products',
        'title_master'          => 'Product Master',
        'title_singular' => 'Product',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'product_image'              => 'Product Image',
            'product_image_helper'       => '',
            'product_name'              => 'Product Name',
            'product_name_helper'       => '',
            'sku'        => 'SKU',
            'sku_helper' => '',
            'short_description'                => 'Short Description',
            'short_description_helper'         => '',
            'opening_quantity'                => 'Opening Quantity',
            'opening_quantity_helper'         => '',
            'category'                => 'Category',
            'category_helper'         => '',
            'sub_category'                => 'Sub Category',
            'sub_category_helper'         => '',
            'units'                => 'Units',
            'units_helper'         => '',
            'expiry_date'                => 'Expiry Date',
            'expiry_date_helper'         => 'The product will not be visible beyond this date.',
            'stock_availability' => 'Stock Availability',
            'stock_availability_helper' => '',
            'in_stock' => 'In Stock',
            'out_of_stock' => 'Out of Stock',
            'status'                => 'Status',
            'status_helper'         => '',
            'product_images' => 'Product Images',
            'product_images_helper' => 'Allowed File Size: 2 MB Max  File Type:  .jpg, .jpeg, .png',
            // 'product_images_helper' => '',
            'select_images' => 'Select Images',
            'select_images_helper' => '',
            'preview' => 'Preview',
            'file_name' => 'File Name',
            'image_description' => 'Image Description',
            'display_order' => 'Display Order',
            'remove' => 'Remove',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'actions'        => 'Actions',
            'actions_helper' => '',
        ],
    ],
    'basket'        => [
        'title'          => 'Baskets',
        'title_master'          => 'Basket Master',
        'title_singular' => 'Basket',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'basket_image'              => 'Basket Image',
            'basket_image_helper'       => '',
            'basket_name'              => 'Basket Name',
            'basket_name_helper'       => '',
            'sku'        => 'SKU',
            'sku_helper' => '',
            'short_description'                => 'Short Description',
            'short_description_helper'         => '',
            'opening_quantity'                => 'Opening Quantity',
            'opening_quantity_helper'         => '',
            'category'                => 'Category',
            'category_helper'         => '',
            'units'                => 'Units',
            'units_helper'         => '',
            'expiry_date'                => 'Expiry Date',
            'expiry_date_helper'         => 'The basket will not be visible beyond this date.',
            'stock_availability' => 'Stock Availability',
            'stock_availability_helper' => '',
            'in_stock' => 'In Stock',
            'out_of_stock' => 'Out of Stock',
            'status'                => 'Status',
            'status_helper'         => '',
            'basket_image' => 'Baskets Image',
            'baskets_images_helper' => 'Allowed File Size: 2 MB Max  File Type:  .jpg, .jpeg, .png',
            'selling_price'                => 'Selling Price',
            'selling_price_helper'         => '',
            'special_price'                => 'Special Price',
            'special_price_helper'         => '',
            'special_price_start_date'                => 'Special Price Start Date',
            'special_price_start_date_helper'         => '',
            'special_price_end_date'                => 'Special Price End Date',
            'special_price_end_date_helper'         => '',
            'min_quantity'                => 'Minimum Quantity',
            'min_quantity_helper'         => 'Minimum quantity that can be purchased at a time.',
            'max_quantity'                => 'Maximum Quantity',
            'max_quantity_helper'         => 'Maximum quantity that can be purchased at a time.',
            'stock_availability' => 'Stock Availability',
            'stock_availability_helper' => '',
            'in_stock' => 'In Stock',
            'out_of_stock' => 'Out of Stock',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            // 'product_images_helper' => '',
            'select_images' => 'Select Images',
            'select_images_helper' => '',
            'preview' => 'Preview',
            'file_name' => 'File Name',
            'image_description' => 'Image Description',
            'display_order' => 'Display Order',
            'remove' => 'Remove',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'actions'        => 'Actions',
            'actions_helper' => '',
            'productUnits' => 'Products',
            'productUnits_helper' => 'Products which are available in the baskets.'
        ],
    ],
    'product_unit'        => [
        'title'          => 'Products',
        'title_singular' => 'Product Unit',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'product'              => 'Product',
            'product_helper'       => '',
            'product_name'              => 'Product Name',
            'product_name_helper'       => '',
            'opening_quantity'                => 'Opening Quantity',
            'opening_quantity_helper'         => '',
            'current_quantity'                => 'Current Quantity',
            'current_quantity_helper'         => '',
            'category'                => 'Category',
            'category_helper'         => '',
            'unit'                => 'Unit',
            'units'                => 'Units',
            'units_helper'         => '',
            'selling_price'                => 'Selling Price',
            'selling_price_helper'         => '',
            'special_price'                => 'Special Price',
            'special_price_helper'         => '',
            'special_price_start_date'                => 'Special Price Start Date',
            'special_price_start_date_helper'         => '',
            'special_price_end_date'                => 'Special Price End Date',
            'special_price_end_date_helper'         => '',
            'min_quantity'                => 'Minimum Quantity',
            'min_quantity_helper'         => 'Minimum quantity that can be purchased at a time.',
            'max_quantity'                => 'Maximum Quantity',
            'max_quantity_helper'         => 'Maximum quantity that can be purchased at a time.',
            'stock_availability' => 'Stock Availability',
            'stock_availability_helper' => '',
            'in_stock' => 'In Stock',
            'out_of_stock' => 'Out of Stock',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'actions'        => 'Actions',
            'actions_helper' => '',
            'add_or_remove_inventory'                => 'Add/Remove Inventory',
            'add_or_remove_inventory_helper'         => '',
            'add_or_remove_product_inventory'        => 'Add/Remove Product Inventory',
            'add_or_remove_product_unit_inventory'   => 'Add/Remove Product Unit Inventory',
            'inventory_type'                => 'Inventory Type',
            'inventory_type_helper'         => '',
            'add'                => 'Add',
            'remove'                => 'Remove',
            'quantity'                => 'Quantity',
            'quantity_helper'         => '',
        ],
    ],
    'category'        => [
        'title'          => 'Categories',
        'title_singular' => 'Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'cat_name'          => 'Name',
            'cat_name_helper'       => '',
            'cat_description'        => 'Category Description',
            'cat_description_helper' => '',
            'cat_image'          => 'Category Image',
            'cat_image_helper'       => '',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'preview' => 'Preview',
            'actions'        => 'Actions',
        ],
    ],
    'unit'        => [
        'title'          => 'Units',
        'title_singular' => 'Unit',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'category'          => 'Category',
            'category_helper'       => '',
            'unit'          => 'Unit',
            'unit_helper'       => '',
            'description'        => 'Description',
            'description_helper' => '',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'banner'        => [
        'title'          => 'Banners',
        'title_singular' => 'Banner',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'          => 'Name',
            'name_helper'       => '',
            'description'        => 'Description',
            'description_helper' => '',
            'image'          => 'Image',
            'image_helper'       => '',
            'banner'                => 'Banner',
            'slider_image'          => 'Slider Image',
            'type' => 'Type',
            'type_helper' => '',
            'url' => 'Url',
            'url_helper' => '',
            'status'                => 'Status',
            'status_helper'         => '',
            'active'                => 'Active',
            'inactive'                => 'InActive',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'preview' => 'Preview',
            'actions'        => 'Actions',
        ],
    ],
    'orderManagement' => [
        'title'          => 'Order Management',
        'title_singular' => 'Order Management',
    ],
    'order'        => [
        'title'          => 'Orders',
        'title_singular' => 'Order',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'customer_name'     => 'Customer Name',
            'delivery_boy_name'     => 'Delivery Boy Name',
            'mobile_number'     => 'Mobile Number',
            'net_amount'     => 'Net Amount',
            'gross_amount'     => 'Gross Amount',
            'discounted_amount'     => 'Discounted Amount',
            'delivery_charge'     => 'Delivery Charge',
            'payment_type' => 'Payment Type',
            'type_helper' => '',
            'products'     => 'Products',
            'mrp'     => 'Mrp',
            'price'     => 'Price',
            'customer_details'     => 'Customer Details',
            'delivery_boy_details'     => 'Delivery Boy Details',
            'order_status'     => 'Order Status',
            'address'     => 'Address',
            'total_price'   => 'Total Price',
            'status'                => 'Status',
            'status_helper'         => '',
            'pending'     => 'Pending',
            'placed'     => 'Placed',
            'picked'     => 'Picked',
            'out_for_delivery'     => 'Out for delivery',
            'delivered'     => 'Delivered',
            'cancelled'     => 'Cancelled',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'actions'        => 'Actions',
            'cancel_order'   => 'Cancel Order',
            're_assign_delivery_boy' => 'Re-assign Delivery Boy',
            'invoice' => 'Invoice',
            'customer_invoice_url' => 'Customer bill',
            'delivery_boy_invoice_url' => 'Delivery invoice',
            'delivery_date' => 'Delivery Date',
            'delivery_date_helper' => '',
        ],
    ],
    'campaign'           => [
        'title'          => 'Campaigns / Offers',
        'title_singular' => 'Campaign/Offer',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'merchant-id' => 'Merchant ID',
            'generic' => 'Generic',
            'unique' => 'Unique',
            'title' => 'Title',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'start_date_helper' => '',
            'code_type' => 'Code Type',
            'end_date' => 'End Date',
            'user_name' => 'User Name',
            'promo_code' => 'Promo code',
            'campaign_use' => 'Code Usage',
            'is_code_used' => 'Is Code Used',
            'campaign_use_value' => 'Code Usage Value',
            'unlimited' => 'Unlimited',
            'limited' => 'Limited',
            'end_date_helper' => '',
            'reward_type' => 'Reward Type',
            'reward_value' => 'Reward Value',
            'loyalty-id' => 'Loyalty ID',
            'code_prefix' => 'Prefix',
            'code_suffix' => 'Suffix',
            'code_length' => 'Code Length',
            'campaign_category_id' => 'Category',
            'code_format ' => 'Code Format Type',
            'campaign_master_id_helper' => '',
            'campaign_master_id' => 'Sub Category',
            'campaign_category_id_helper' => '',
            'loyalty-tier-id' => 'Loyalty tier ID',
            'push-notification' => 'Push notification',
            'sms-notification' => 'SMS notification',
            'message-type-1' => 'Offer',
            'message-type-2' => 'Message',
            'message-type-3' => 'Product',
            'offer-id' => 'Offer',
            'message-send-date' => 'Send Date',
            'message-send-time' => 'Send Time',
            'for-testing' => 'For Testing',
            'product-id' => 'Product',
            'email-from-name' => 'Sender Name',
            'email-from-email' => 'Sender Email',
            'email-subject' => 'Email Subject',
            'email-body' => 'Email Body',
            'push-text' => 'Notification Text',
            'test-email-addresses' => 'Email Address',
            'help-test-email-addresses' => 'Add single email address to test email. Ex. emai11@domain.com.',
            'test-mobile-numbers' => 'Mobile Number',
            'help-test-mobile-numbers' => 'Add single mobile to test message. Ex. 9898989898.',
            'deep-link-screen' => 'Deep Link Screen',
            'sms-text' => 'Message Text',
            'city_from'         => 'City From',
            'city_from_helper'  => '',
            'date_from'         => 'Date From',
            'date_from_helper'  => '',
            'city_to'           => 'City To',
            'city_to_helper'    => '',
            'date_to'           => 'Date To',
            'date_to_helper'    => '',
            'adults'            => 'Adults',
            'adults_helper'     => '',
            'children'          => 'Children',
            'children_helper'   => '',
            'notification'      => 'Message Notify By',
            'message-type'      => 'Message type',
            'message-title'     => 'Message title',
            'message-send-date-time' => 'Message send date time',
            'message-send-date' => 'Message send date',
            'message-send-time' => 'Message send time',
            'filter_or_upload'  => '',
            'apply_filters' => 'Apply filters',
            'upload_files' => 'Upload files',
            'gender_filter' => '',
            'emails' => 'Emails',
            'mobiles' => 'Mobiles',
            'filter_or_upload_helper' => '',
            'upload_file' => '',
            'gender' => 'Gender',
            'email' => 'Email',
            'active'                => 'Active',
            'inactive'                => 'Inactive',
            'sms' => 'SMS',
            'email_count'       => 'Email count',
            'sms-notification' => 'SMS Notification',
            'all' => 'All',
            'region' => 'Region',
            'regions' => 'Regions',
            'custom' => 'Custom',
            'user' => 'User Type',
            'customer' => 'Customer',
            'users' => 'Target users',
            'delivery_boy' => 'Delivery boy',
            'sms_count'         => 'SMS count',
            'users_helper' => '',
            'status'            => 'Status',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'users_helper' => '',
            'regions_helper' => '',
            'processed' => 'Processed',
        ],
    ],
    'communication'           => [
        'title'          => 'Communication',
        'title_singular' => 'Communication',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'merchant-id' => 'Merchant ID',
            'loyalty-id' => 'Loyalty ID',
            'loyalty-tier-id' => 'Loyalty tier ID',
            'push-notification' => 'Push notification',
            'sms-notification' => 'SMS notification',
            'message-type-1' => 'Offer',
            'message-type-2' => 'Message',
            'message-type-3' => 'Product',
            'offer-id' => 'Offer',
            'message-send-date' => 'Send Date',
            'message-send-time' => 'Send Time',
            'for-testing' => 'For Testing',
            'product-id' => 'Product',
            'email-from-name' => 'Sender Name',
            'email-from-email' => 'Sender Email',
            'email-subject' => 'Email Subject',
            'email-body' => 'Email Body',
            'push-text' => 'Notification Text',
            'test-email-addresses' => 'Email Address',
            'help-test-email-addresses' => 'Add single email address to test email. Ex. emai11@domain.com.',
            'test-mobile-numbers' => 'Mobile Number',
            'help-test-mobile-numbers' => 'Add single mobile to test message. Ex. 9898989898.',
            'deep-link-screen' => 'Deep Link Screen',
            'sms-text' => 'Message Text',
            'city_from'         => 'City From',
            'city_from_helper'  => '',
            'date_from'         => 'Date From',
            'date_from_helper'  => '',
            'city_to'           => 'City To',
            'city_to_helper'    => '',
            'date_to'           => 'Date To',
            'date_to_helper'    => '',
            'adults'            => 'Adults',
            'adults_helper'     => '',
            'children'          => 'Children',
            'children_helper'   => '',
            'notification'      => 'Message Notify By',
            'message-type'      => 'Message type',
            'message-title'     => 'Message title',
            'message-send-date-time' => 'Message send date time',
            'message-send-date' => 'Message send date',
            'message-send-time' => 'Message send time',
            'filter_or_upload'  => '',
            'apply_filters' => 'Apply filters',
            'upload_files' => 'Upload files',
            'gender_filter' => '',
            'emails' => 'Emails',
            'mobiles' => 'Mobiles',
            'filter_or_upload_helper' => '',
            'upload_file' => '',
            'gender' => 'Gender',
            'email' => 'Email',
            'active'                => 'Active',
            'inactive'                => 'Inactive',
            'sms' => 'SMS',
            'email_count'       => 'Email count',
            'sms-notification' => 'SMS Notification',
            'all' => 'All',
            'region' => 'Region',
            'regions' => 'Regions',
            'custom' => 'Custom',
            'user' => 'User Type',
            'customer' => 'Customer',
            'users' => 'Target users',
            'delivery_boy' => 'Delivery boy',
            'sms_count'         => 'SMS count',
            'users_helper' => '',
            'status'            => 'Status',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'users_helper' => '',
            'regions_helper' => '',
            'processed' => 'Processed',
        ],
    ],
    'purchase_form'        => [
        'title'          => 'Purchase Form',
        'title_singular' => 'Purchase Form',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'supplier_name'          => 'Supplier Name',
            'supplier_name_helper'       => '',
            'product_name'          => 'Product Name',
            'product_name_helper'       => '',
            'unit'        => 'Unit',
            'unit_helper' => '',
            'category'          => 'Category',
            'category_helper'       => '',
            'purchase_form'         => 'Purchase Form',
            'price'          => 'Price',
            'price_helper'       => '',
            'order_date' => 'Order Date',
            'order_date_helper' => '',
            'total_in_kg' => 'Total In Kg',
            'total_in_kg_helper' => '',
            'total_units'                => 'Total Units',
            'total_units_helper'         => '',
            'preview' => 'Preview',
            'actions'        => 'Actions',
        ],
    ],
    'report' => [
        'title'          => 'Reports',
        'title_singular' => 'Report',
        'fields'         => [
            'sales_itemwise' => 'Sales Itemwise',
            'sales_orderwise_item' => 'Sales Orderwise Item',
            'sales_for_supplier' => 'Sales For Supplier',
        ],
    ],
    'sales_itemwise' => [
        'title'          => 'Sales Itemwise',
        'title_singular' => 'Sales Itemwise',
        'fields'         => [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'product_name' => 'Product Name',
            'item_qty' => 'Item Qty',
            'unit' => 'Unit',
            'cat_name' => 'Category',
            'order_date' => 'Order Date',
        ],
    ],
    'sales_orderwise_item' => [
        'title'          => 'Sales Orderwise Item',
        'title_singular' => 'Sales Orderwise Item',
        'fields'         => [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'order_id' => 'Order Id',
            'product_name' => 'Product Name',
            'item_qty' => 'Item Qty',
            'unit' => 'Unit',
            'cat_name' => 'Category',
            'order_date' => 'Order Date',
            'order_status' => 'Order Status',
        ],
    ],
    'sales_for_supplier' => [
        'title'          => 'Sales For Supplier',
        'title_singular' => 'Sales For Supplier',
        'fields'         => [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'product_name' => 'Product Name',
            'item_qty' => 'Item Qty',
            'unit' => 'Unit',
            'cat_name' => 'Category',
            'order_date' => 'Order Date',
            'prod_units' => 'Units',
            'prod_units_qty' => 'Product Units Qty'
        ],
    ],
    'loginlogs' => [
        'title'          => 'Login Logs',
        'title_singular' => 'Login Log',
        'fields'         => [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'name' => 'Name',
            'platform' => 'Platform',
            'login_time' => 'Activity Time',
            'is_login' => 'Activity',
        ],
    ],
];

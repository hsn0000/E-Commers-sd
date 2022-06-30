<?php

use Illuminate\Database\Seeder;

class Modules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('module')->insert([
            [
                // 1
                'parent_id' => 0,
                'mod_name' => 'Master',
                'mod_alias' => 'master',
                'mod_permalink' => '/master',
                'mod_icon' => 'icon icon-th-large',
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 2
                'parent_id' => 1,
                'mod_name' => 'User',
                'mod_alias' => 'user',
                'mod_permalink' => '/user',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 3
                'parent_id' => 2,
                'mod_name' => 'Profile User',
                'mod_alias' => 'profile-user-admin',
                'mod_permalink' => '/profile-usr/admin',
                'mod_icon' => null,
                'mod_order' => 2,
                'published' => 'y'
            ],
            [
                // 4
                'parent_id' => 0,
                'mod_name' => 'Product',
                'mod_alias' => 'product',
                'mod_permalink' => '/product',
                'mod_icon' => 'icon icon-shopping-cart',
                'mod_order' => 2,
                'published' => 'y'
            ],
            [
                // 5
                'parent_id' => 4,
                'mod_name' => 'Categori',
                'mod_alias' => 'categori',
                'mod_permalink' => '/categori/admin',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 6
                'parent_id' => 4,
                'mod_name' => 'Production',
                'mod_alias' => 'production',
                'mod_permalink' => '/production/admin',
                'mod_icon' => null,
                'mod_order' => 2,
                'published' => 'y'
            ],
            [
                // 7
                'parent_id' => 0,
                'mod_name' => 'Events',
                'mod_alias' => 'events',
                'mod_permalink' => '/events',
                'mod_icon' => 'icon icon-gift',
                'mod_order' => 4,
                'published' => 'y'
            ],
            [
                // 8
                'parent_id' => 7,
                'mod_name' => 'Coupons',
                'mod_alias' => 'coupons',
                'mod_permalink' => '/coupons/admin',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 9
                'parent_id' => 0,
                'mod_name' => 'Advertisement',
                'mod_alias' => 'advertisement',
                'mod_permalink' => '/advertisement',
                'mod_icon' => 'icon icon-tags',
                'mod_order' => 5,
                'published' => 'y'
            ],
            [
                // 10
                'parent_id' => 9,
                'mod_name' => 'Banner',
                'mod_alias' => 'banner',
                'mod_permalink' => '/banner/admin',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 11
                'parent_id' => 9,
                'mod_name' => 'Billboard',
                'mod_alias' => 'billboard',
                'mod_permalink' => '/billboard/admin',
                'mod_icon' => null,
                'mod_order' => 2,
                'published' => 'y'
            ],
            [
                // 12
                'parent_id' => 9,
                'mod_name' => 'Cms Page',
                'mod_alias' => 'cms-page',
                'mod_permalink' => '/cms-page/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 13
                'parent_id' => 9,
                'mod_name' => 'Newsletter Subscribtion',
                'mod_alias' => 'newsletter-subscribtion',
                'mod_permalink' => '/newsletter-subscribtion/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 14
                'parent_id' => 9,
                'mod_name' => 'News Information',
                'mod_alias' => 'news-information',
                'mod_permalink' => '/news-information/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 15
                'parent_id' => 9,
                'mod_name' => 'Inquiries',
                'mod_alias' => 'inquiries',
                'mod_permalink' => '/inquiries/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 16
                'parent_id' => 0,
                'mod_name' => 'Web Setting',
                'mod_alias' => 'web-setting',
                'mod_permalink' => '/web-setting',
                'mod_icon' => 'icon icon-cogs',
                'mod_order' => 7,
                'published' => 'y'
            ],
            [
                // 17
                'parent_id' => 16,
                'mod_name' => 'Currencies',
                'mod_alias' => 'currencies',
                'mod_permalink' => '/currencies/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 18
                'parent_id' => 0,
                'mod_name' => 'Transaction',
                'mod_alias' => 'transaction',
                'mod_permalink' => '/transaction',
                'mod_icon' => 'icon icon-money',
                'mod_order' => 4,
                'published' => 'y'
            ],
            [
                // 19
                'parent_id' => 18,
                'mod_name' => 'Orders',
                'mod_alias' => 'orders-admin',
                'mod_permalink' => '/orders-admin/admin',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 20
                'parent_id' => 18,
                'mod_name' => 'Shipping',
                'mod_alias' => 'shipping',
                'mod_permalink' => '/shipping/admin',
                'mod_icon' => null,
                'mod_order' => 2,
                'published' => 'y'
            ],
            [
                // 21
                'parent_id' => 18,
                'mod_name' => 'Summary Order',
                'mod_alias' => 'summary-order',
                'mod_permalink' => '/summary-order/admin',
                'mod_icon' => null,
                'mod_order' => 3,
                'published' => 'y'
            ],
            [
                // 22
                'parent_id' => 0,
                'mod_name' => 'Live Chat',
                'mod_alias' => 'live-chat',
                'mod_permalink' => '/live-chat',
                'mod_icon' => 'icon icon-envelope',
                'mod_order' => 8,
                'published' => 'y'
            ],
            [
                // 23
                'parent_id' => 22,
                'mod_name' => 'Messages',
                'mod_alias' => 'messages',
                'mod_permalink' => '/messages/admin/messages',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 24
                'parent_id' => 1,
                'mod_name' => 'User Admin',
                'mod_alias' => 'user-admin',
                'mod_permalink' => '/user/admin',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
            [
                // 25
                'parent_id' => 1,
                'mod_name' => 'User Group',
                'mod_alias' => 'user-group',
                'mod_permalink' => '/user/group',
                'mod_icon' => null,
                'mod_order' => 1,
                'published' => 'y'
            ],
        ]);
    }
}

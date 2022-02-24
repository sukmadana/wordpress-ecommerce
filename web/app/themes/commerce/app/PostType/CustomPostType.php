<?php

namespace Commerce\PostType;

abstract class CustomPostType
{
    protected static $postType = 'custom_post_type';

    protected static $postName = 'Custom Post Type';

    protected static $singularName = 'Custom Post Type';

    protected static $pluralName = 'Custom Post Types';

    protected static $supports = array(
        'title',
        'editor',
        'thumbnail',
        'page-attributes',
        'excerpt'
    );

    protected static $hierarchical = false;

    protected static $public = true;

    protected static $showInMenu = true;

    protected static $showInNavMenus = false;

    protected static $hasArchive = true;

    protected static $rewriteSlug = '';

    protected static $excludeFromSearch = false;

    protected static $publiclyQueryable = true;

    protected static $menuIcon = 'dashicons-index-card';


    public static function register()
    {
        register_post_type( static::postType(), [
            'label'               => __( static::postName(), env('TEXT_DOMAIN') ),
            'labels'              => array(
                'name'                => _x( static::pluralName(), 'Post Type General Name', env('TEXT_DOMAIN') ),
                'singular_name'       => _x( static::singularName(), 'Post Type Singular Name', env('TEXT_DOMAIN') ),
                'menu_name'           => __( static::pluralName(), env('TEXT_DOMAIN') ),
                'name_admin_bar'      => __( static::pluralName(), env('TEXT_DOMAIN') ),
                'add_new_item'        => __( 'Add New ' . static::singularName(), env('TEXT_DOMAIN') ),
                'add_new'             => __( 'Add New ' . static::singularName(), env('TEXT_DOMAIN') ),
                'new_item'            => __( 'New ' . static::singularName(), env('TEXT_DOMAIN') ),
                'edit_item'           => __( 'Edit ' . static::singularName(), env('TEXT_DOMAIN') ),
                'update_item'         => __( 'Update ' . static::singularName(), env('TEXT_DOMAIN') ),
                'view_item'           => __( 'View ' . static::singularName(), env('TEXT_DOMAIN') ),
                'search_items'        => __( 'Search ' . static::pluralName(), env('TEXT_DOMAIN') ),
            ),
            'supports'            => static::supports(),
            'hierarchical'        => static::hierarchical(),
            'public'              => static::isPublic(),
            'show_ui'             => true,
            'show_in_menu'        => static::showInMenu(),
            'menu_position'       => 5,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => static::showInNavMenus(),
            'can_export'          => true,
            'has_archive'         => static::hasArchive(),
            'rewrite'             => array(
                'slug' => static::rewriteSlug() == '' ? static::postType() : static::rewriteSlug()
            ),  
            'exclude_from_search' => static::excludeFromSearch(),
            'publicly_queryable'  => static::publiclyQueryable(),
            'capability_type'     => 'post',
            'menu_icon'           => static::menuIcon(),
        ] );
    }

    public static function postType()
    {
        return static::$postType;
    }

    public static function postName()
    {
        return static::$postName;
    }

    public static function singularName()
    {
        return static::$singularName;
    }

    public static function pluralName()
    {
        return static::$pluralName;
    }

    public static function supports()
    {
        return static::$supports;
    }

    public static function hierarchical()
    {
        return static::$hierarchical;
    }

    public static function isPublic()
    {
        return static::$public;
    }

    public static function showInMenu() {
        return static::$showInMenu;
    }

    public static function showInNavMenus() {
        return static::$showInNavMenus;
    }

    public static function hasArchive() {
        return static::$hasArchive;
    }

    public static function rewriteSlug() {
        return static::$rewriteSlug;
    }

    public static function excludeFromSearch()
    {
        return static::$excludeFromSearch;
    }

    public static function publiclyQueryable()
    {
        return static::$publiclyQueryable;
    }

    public static function menuIcon() {
        return static::$menuIcon;
    }

}

<?php
/**
 * ToysLand Theme Header
 *
 * @package ToysLand
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="toysland-site-header" role="banner">
    <!-- Announcement Top Bar -->
    <?php get_template_part('template-parts/header/announcement-bar'); ?>

    <!-- Main Sticky Header -->
    <?php get_template_part('template-parts/header/main-header'); ?>

    <!-- Desktop Navigation Bar & Mega Menu -->
    <?php get_template_part('template-parts/header/nav-bar'); ?>
</header>

<main id="primary" class="site-main" role="main">


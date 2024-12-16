<?php
function breadcrumbs($separator = ' &raquo; ', $home = 'Home')
{
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $breadcrumbs = array("<a style='text-decoration:none; color:black;' href=\"$base\">$home</a>");
    $crumbs = '';
    $last = end(array_keys($path));

    foreach ($path as $x => $crumb) {
        $title = ucwords(str_replace(array('.php', '_', '%20'), array('', ' ', ' '), $crumb));

        if ($x != $last) {
            $breadcrumbs[] = "<a style='text-decoration:none; color:black;' href=\"$base$crumbs$crumb\">$title</a>";
            $crumbs .= $crumb . '/';
        }
        else {
            $breadcrumbs[] = $title;
        }
    }
    return implode($separator, $breadcrumbs);
}
?>

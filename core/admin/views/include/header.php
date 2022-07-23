<!--<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta type="keywords" content="...">
    <meta type="description" content="...">
    <title>Document</title>


</head>
<body>
<div class="vg-carcass vg-hide">
    <div class="vg-main">
        <div class="vg-one-of-twenty vg-firm-background-color2  vg-center">
            <a href="<?= PATH ?>" target="_blank">
                <div class="vg-element vg-full">
                    <span class="vg-text2 vg-firm-color1">Site</span>
                </div>
            </a>
        </div>
        <div class="vg-element vg-ninteen-of-twenty vg-firm-background-color4 vg-space-between  vg-box-shadow">
            <div class="vg-element vg-third">
                <div class="vg-element vg-fifth vg-center" id="hideButton">
                    <div>
                        <img src="<?= PATH.ADMIN_TEMPLATE ?>img/menu-button.png" alt="">
                    </div>
                </div>
                <div class="vg-element vg-wrap-size vg-left vg-search  vg-relative" id="searchButton">
                    <div>
                        <img src="<?= PATH.ADMIN_TEMPLATE ?>img/search.png" alt="">
                    </div>
                    <form method="post" action="<?= PATH.\core\base\settings\Settings::get("route")["admin"]["alias"] ?>/search" autocomplete="off">
                        <input type="text" name="search" class="vg-input vg-text">
                        <div class="vg-element vg-firm-background-color4 vg-box-shadow search_links search_res"></div>
                    </form>
                </div>
            </div>

            <a href="<?= PATH.\core\base\settings\Settings::get("route")["admin"]["alias"] ?>/createsitemap" class="vg-element vg-box-shadow sitemap-button">
                            <span class="vg-text vg-firm-color1">
                                Create sitemap
                            </span>
            </a>

            <div class="vg-element vg-fifth">
                <div class="vg-element vg-half vg-right">
                    <div class="vg-element vg-text vg-center">
                        <span class="vg-firm-color5">admin</span>
                    </div>
                </div>
                <a href="/login/admin/logout/1" class="vg-element vg-half vg-center">
                    <div>
                        <img src="<?= PATH.ADMIN_TEMPLATE ?>img/out.png" alt="">
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="vg-main vg-right vg-relative">
        <div class="vg-wrap vg-firm-background-color1 vg-center vg-block vg-menu">

            <?php if($this->menu): ?>
                <?php foreach ($this->menu as $table => $item): ?>

                    <a href="<?= $this->AdminPath ?>show/<?=$table?>" class="vg-wrap vg-element vg-full vg-center ">
                        <div class="vg-element vg-half  vg-center">
                            <div>
                                <img src="<?= PATH.ADMIN_TEMPLATE ?>img/<?= $item["img"] ? $item["img"] : "pages.png" ?>" alt="pages">
                            </div>
                        </div>
                        <div class="vg-element vg-half vg-center vg_hidden">
                            <span class="vg-text vg-firm-color5"><?= $item["name"] ? $item["name"] : $table ?></span>
                        </div>
                    </a>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
</body>
</html>-->

<!DOCTYPE html>

<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title> Drop Down Sidebar Menu | CodingLab </title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php foreach ($this->styles as $style):?>
        <link rel="stylesheet" href="<?= $style ?>">
    <?php endforeach; ?>
</head>
<body>
<div class="sidebar close">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
        <span class="logo_name">site</span>
    </div>
    <ul class="nav-links">

        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-collection' ></i>
                    <span class="link_name">Category</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Category</a></li>
                <li><a href="#">HTML & CSS</a></li>
            </ul>
        </li>

    </ul>
</div>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Drop Down Sidebar</span>
    </div>
</section>




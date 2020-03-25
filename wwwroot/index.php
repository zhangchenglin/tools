<?php
define('title', '在线小工具');
require_once './header.php';
?>
<link rel="stylesheet" href="static/css/index.min.css">

<div class="pt-3 pt-md-4 pt-lg-5 container" id="jt_index">
    <div class="mb-3 d-flex justify-content-center" id="jt_category">
        <div class="mx-auto w-50 w-sm-50 w-lg-25 btn-group btn-group-sm bg-white">
            <a class="btn border btn-outline-secondary active" id="tools-collapse">所有</a>
            <a class="btn border btn-outline-secondary" id="collapse-enquiry">查询</a>
            <a class="btn border btn-outline-secondary" id="collapse-conversion">转换</a>
            <a class="btn border btn-outline-secondary" id="collapse-other">其他</a>
        </div>
    </div>
    <div class="row justify-content-center row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4" id="jt_list">
        <div class="col mb-3 tools-collapse collapse-enquiry collapse show">
            <div class="card h-100 hvr-wobble-bottom">
                <div class="d-flex justify-content-between card-header py-2">
                    <a class="stretched-link text-dark font-weight-bold text-decoration-none" href="/phone_number/"
                       title="公共电话本" style="font-size: 95%;"><i class="mr-2 text-success fa-lg fas fa-address-book"></i>公共电话本</a>
                    <div class="category_name text-muted small">[&nbsp;查询&nbsp;]</div>
                </div>
                <div class="card-body">
                    <p class="card-desc card-text small">公开的电话号码本。</p>
                </div>
            </div>
        </div>
        <div class="col mb-3 tools-collapse collapse-conversion collapse show">
            <div class="card h-100 hvr-wobble-bottom">
                <div class="d-flex justify-content-between card-header py-2">
                    <a class="stretched-link text-dark font-weight-bold text-decoration-none" href="/qrcode/"
                       title="照片详情信息" style="font-size: 95%;"><i class="mr-2 text-success fa-lg fas fa-qrcode"></i>灵活码</a>
                    <div class="category_name text-muted small">[&nbsp;转换&nbsp;]</div>
                </div>
                <div class="card-body">
                    <p class="card-desc card-text small">动态管理二维码结果。</p>
                </div>
            </div>
        </div>
        <div class="col mb-3 tools-collapse collapse-other collapse show">
            <div class="card h-100 hvr-wobble-bottom">
                <div class="d-flex justify-content-between card-header py-2">
                    <a class="stretched-link text-dark font-weight-bold text-decoration-none" href="/photo_info/"
                       title="照片详情信息" style="font-size: 95%;"><i class="mr-2 text-success fa-lg fas fa-image"></i>照片详情信息</a>
                    <div class="category_name text-muted small">[&nbsp;其他&nbsp;]</div>
                </div>
                <div class="card-body">
                    <p class="card-desc card-text small">查看照片的EXIF信息。</p>
                </div>
            </div>
        </div>
    </div>

</div>

<div>
    <?php require_once "javascript.php"; ?>
    <script src="static/js/index.min.js"></script>
    <script src="static/js/survey.min.js"></script>
</div>

<?php
require_once './footer.php';
?>
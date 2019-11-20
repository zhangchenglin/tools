$().ready(function () {
    bsCustomFileInput.init()
});


/** 提交图片 **/
let photo_submit = document.querySelector("#photo_submit");
let photo_input = document.querySelector("#photo_input");
let photo_label = document.querySelector("#photo_label");
let photo_url = "/photo_info/photoinfo.php";

photo_input.addEventListener("change", function () {
    validation_valid_div(this, "通过");
    input_success(this);
});
photo_submit.addEventListener("click", function () {
    submit_images(photo_input);
    set_recaptcha_action("photo_info");
});

function validation_files_type(element) {
    let files = element.files;
    for (let x = files.length, i = 0; i < x; i++) {
        console.log(files[i]["name"]);
    }
    return true;
}

function get_images() {
    const images = photo_input.files;
    console.table(images);
    if (1) {
        return images;
    } else {
        return false;
    }
}

function submit_images(element) {
    let data = get_images();
    let validation_result = validation_files_type(photo_input);
    if (validation_result) {
        // validation_valid_div(element, "通过");
        $.ajax({
            url: photo_url,
            method: "post",
            cache: false,
            timeout: 10000,
            contentType: "multipart/form-data",
            data: data,
            beforeSend: function () {
                add_spinner_icon(photo_submit);
            },
            success: function (data) {
                setInterval(function () {
                    remove_spinner_icon(photo_submit);
                }, 3000);
                console.log("成功");
                console.log(data.result);
            },
            error: function (error) {
                console.log("失败");
                console.log(error);
            }
        });
    } else {
        // validation_invalid_div(element, "通过");
    }

}
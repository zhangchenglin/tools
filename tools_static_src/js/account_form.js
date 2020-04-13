// 第三方登录提示
(function () {
  let oauth_sign_in = document.querySelector("#oauth_sign_in");
  if (oauth_sign_in) {
    oauth_sign_in.addEventListener('click', function (e) {
      let e_target = e.target;
      if (e_target.dataset['title']) {
        let e_title = e_target.dataset["title"];
        let tip = `<div class="text-center text-warning">${e_title}功能正在开发中</div>`;
        bootstrapModalJs('', tip, '', 'sm', true);
      }
    })
  }
})();

// 登录切换
(function () {
  let sign_tab = document.querySelector('#sign_tab');
  if (sign_tab) {
    sign_tab.addEventListener('click', function (e) {
      let e_target = e.target;
      if ('BUTTON' === e_target.tagName) {
        $(e_target).tab('show');
      }
    });

    let $sign_tab_btn = $('#sign_tab button');
    $sign_tab_btn.on('show.bs.tab', function (e) {
      let e_target = e.target;
      let e_relatedTarget = e.relatedTarget;
      console.log($(e_target));
      console.log(e_target);
      console.log($(e_relatedTarget));
      console.log(e_relatedTarget);
    });

    $sign_tab_btn.on('shown.bs.tab', function (e) {
      let e_target = e.target;
      let e_relatedTarget = e.relatedTarget;
      console.log($(e_target));
      console.log(e_target);
      console.log($(e_relatedTarget));
      console.log(e_relatedTarget);
    });

  }
})();

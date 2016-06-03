<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?>社團/財團法人資料檢索</title><?php
        $trailDesc = '社團/財團法人資料檢索提供簡單的介面檢索國內有登記立案的社團/財團法人';
        if (!isset($desc_for_layout)) {
            $desc_for_layout = $trailDesc;
        } else {
            $desc_for_layout .= $trailDesc;
        }
        echo $this->Html->meta('description', $desc_for_layout);
        echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
        echo $this->Html->meta('icon');
        echo $this->Html->css('jquery-ui');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('default');
        ?>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-5571465503362954",
        enable_page_level_ads: true
        });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <?php echo $this->Html->link('社團 / 財團法人資料檢索', '/', array('class' => 'navbar-brand')); ?>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>&nbsp;</p>
                    <p class="hidden-sm hidden-xs">&nbsp;</p>
                    <form class="search-form">
                        <div class="input-group input-group-lg">
                            <input type="text" id="keyword" value="<?php echo isset($name) ? $name : ''; ?>" class="form-control" placeholder="搜尋…" autofocus>
                            <div class="input-group-btn">
                                <a href="#" class="btn btn-primary btn-foundation">找法人</a>
                                <a href="#" class="btn btn-primary btn-director">找個人</a>
                            </div>
                        </div>
                    </form>
                </div>
                <p class="hidden-sm hidden-xs">&nbsp;</p>
                <div class="col-md-12">
                    <div class="btn-group">
                        <?php if (Configure::read('loginMember.id')): ?>
                            <?php echo $this->Html->link('Foundations', '/admin/foundations', array('class' => 'btn')); ?>
                            <?php echo $this->Html->link('Directors', '/admin/directors', array('class' => 'btn')); ?>
                            <?php echo $this->Html->link('Members', '/admin/members', array('class' => 'btn')); ?>
                            <?php echo $this->Html->link('Groups', '/admin/groups', array('class' => 'btn')); ?>
                            <?php echo $this->Html->link('Logout', '/members/logout', array('class' => 'btn')); ?>
                        <?php endif; ?>
                        <?php
                        if (!empty($actions_for_layout)) {
                            foreach ($actions_for_layout as $title => $url) {
                                echo $this->Html->link($title, $url, array('class' => 'btn'));
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                 <?php echo $this->Session->flash(); ?>
                 <?php echo $content_for_layout; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:728px;height:90px"
                         data-ad-client="ca-pub-5571465503362954"
                         data-ad-slot="5474383621">
                    </ins>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="fb-page" data-href="https://www.facebook.com/k.olc.tw" data-width="600" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="fb-page" data-href="https://www.facebook.com/g0v.tw" data-width="600" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
                        </div>
                    </div>
                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id))
                                return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=1393405437614114&version=v2.3";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                </div>
            </div>
        </div>
        <footer class="navbar-bottom navbar navbar-default">
            <div class="container">
                <div class="row">
                    <ul>
                        <li>
                            <?php echo $this->Html->link('江明宗 . 政 . 路過', 'http://k.olc.tw/', array('target' => '_blank')); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('關於本站', '/pages/about'); ?>
                        </li>
                        <?php
                            if (!Configure::read('loginMember.id')) {
                                echo $this->Html->tag(
                                    'li',
                                    $this->Html->link('登入', '/members/login')
                                );
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </footer>
        <?php
        // echo $this->element('sql_dump');
        echo $this->Html->script('jquery');
        echo $this->Html->script('jquery-ui');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('olc');
        echo $this->Html->script('zhutil.min');
        echo $this->fetch('scriptBottom');
        echo $scripts_for_layout;
        ?>
        <script>
            $(function () {
                $('.search-form').on('submit', function (e) {
                    e.preventDefault();
                })
                $('.btn-foundation').on('click', function (e) {
                    var keyword = $('#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/foundations/index/'); ?>' + encodeURIComponent(keyword);
                    }
                    e.preventDefault();
                });
                $('.btn-director').on('click', function (e) {
                    var keyword = $('#keyword').val();
                    if (keyword !== '') {
                        location.href = '<?php echo $this->Html->url('/directors/index/'); ?>' + encodeURIComponent(keyword);
                    }
                    e.preventDefault();
                });
            });
        </script>
        <?php if (Configure::read('debug') === 0) { ?>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-40055059-5', 'auto');
                ga('send', 'pageview');
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        <?php } ?>
    </body>
</html>

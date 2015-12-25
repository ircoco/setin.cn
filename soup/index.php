<!DOCTYPE html>
<?php
define('PAGE_SIZE', 10);
require_once('../inc/mysql.inc.php');
require_once('../inc/soup.inc.php');

$page_num = isset($_GET['page']) ? strip_tags(mysql_escape_string($_GET['page'])) : 1;
$tag = isset($_GET['s']) ? strip_tags(mysql_escape_string($_GET['s'])) : '';
if ($page_num <= 0) {
    $page_num = 1;
}

$SoupDao = new SoupDao;
$soup_online_cnt = $SoupDao->count($tag);
//print_r($joke_online_cnt);
$page_total = floor(($soup_online_cnt - 1) / PAGE_SIZE) + 1; //总页数
$soups = $SoupDao->findByPage($page_num,$tag);
Mysql::close();
?>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8" />
        <meta name="renderer" content="webkit" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta http-equiv="Cache-Control" content="no-transform " /> 
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="Bookmark" href="/res/soup/favicon.ico" />
        <link rel="shortcut icon" href="/res/soup/favicon.ico" />
		<title><?php if(!empty($tag)){echo '与“' . $tag . '”相关的心灵鸡汤 | ';} ?>心灵鸡汤 - 每日鸡汤</title>
        <meta name="keywords" content="心灵鸡汤,每日鸡汤" />
        <meta name="description" content="心灵鸡汤,每日鸡汤" />
        <script type="text/javascript" src="/res/soup/js/share.js"></script>
        <link rel='stylesheet' id='joke-style-css'  href='/res/joke/jokecss.css' type='text/css' media='all' />
    </head>
    <body>
        <div id="main" class="clearfix">
            <div id="content">
                <div class="panel">
                    <div class="body clearfix">
                        <a class="logo left" href="http://soup.setin.cn/" title="心灵鸡汤">心灵鸡汤</a>
                        <div>
                            <h1><a href="http://soup.setin.cn/">心灵鸡汤</a></h1>
                            <p>我们不生产心灵鸡汤，我们只是心灵鸡汤的搬运工</p>
                        </div>
                    </div>
                </div>
                <p class="tips">正在浏览 <?php echo date("Y-m-d H:i:s", time()); ?> 之前发布<?php echo empty($tag) ? '' : '的关于“ ' . $tag . ' ”' ?>的心灵鸡汤，共 <?php echo $soup_online_cnt; ?>条
                    <a href="http://soup.setin.cn/">（点击返回最新）</a>  第 <?php echo $page_num; ?> 页
                </p>
		<?php 
		$cnt = 0;
		foreach ($soups as &$soup) { 
		$cnt ++;
		if ($cnt == 5) {
		?>
			<!--<div class="panel">
    		    <div class="body">
					<p>
						<ins class="adsbygoogle"
							 style="display:block"
							 data-ad-client="ca-pub-7292810486004926"
							 data-ad-slot="7806394673"
							 data-ad-format="auto"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</p>
    		    </div>
    		    <div class="footer clearfix">
					<a href="javascript:;" onclick="tags_toggle(this)" class="tags-toggle">关键词</a>
					<script>share_output('http://soup.setin.cn/<?php echo $soup['id']; ?>.html', "<?php echo preg_replace("/\s/", "", $soup['content']); ?>");</script>
					<a href="/<?php echo $soup['id']; ?>.html"><?php echo $soup['posttime']; ?></a>
    		    </div>
    		    <div class="footer tags">
					<a href='http://soup.setin.cn/?s=心灵鸡汤'>心灵鸡汤</a>、<a href='http://soup.setin.cn/?s=广告'>广告</a>
    		    </div>
    		</div>	-->
		<?php
		}
		?>
				
    		<div class="panel">
    		    <div class="body">
    			<p><?php echo $soup['content']; ?></p>
    		    </div>
    		    <div class="footer clearfix">
    			<a href="javascript:;" onclick="tags_toggle(this)" class="tags-toggle">关键词</a>
    			<script>share_output('http://soup.setin.cn/<?php echo $soup['id']; ?>.html', "<?php echo preg_replace("/\s/", "", $soup['content']); ?>");</script>
    			<a href="/<?php echo $soup['id']; ?>.html"><?php echo $soup['posttime']; ?></a>
    		    </div>
    		    <div class="footer tags">
			    <?php
			    if (isset($soup['tag'])) {
				$tags_array = explode(',', $soup['tag']);
				foreach ($tags_array as $tag_item) {
				    echo "<a href='http://soup.setin.cn/?s=$tag_item'>$tag_item</a>、";
				}
			    }
			    ?>
    		    </div>
    		</div>
		<?php } ?>
                <ul class="pagination clearfix">
		    <?php
		    $navs = array();

		    if ($page_num != 1) {
			$navs[] = '-1'; //-1表示上一页
		    }
                   
		    //起始分页
		    for ($i = 1; $i <= 3; $i ++) {
			if ($i <= $page_total) {
			    $navs[] = $i;
			}
		    }
                 
                   
		    //中间的分页
		    if ($page_num > 5) {
			$navs[] = -2; //-2代表...
		    }
		    for ($i = $page_num - 1; $i <= $page_num + 1; $i ++) {
			if (!in_array($i, $navs) && $i > 0 && $i <= $page_total) {
			    $navs[] = $i;
			}
		    }

		    //结束分页
		    if ($page_num < $page_total - 4) {
			$navs[] = -2; //-2代表...
		    }
		    for ($i = $page_total - 2; $i <= $page_total; $i ++) {
			if (!in_array($i, $navs) && $i > $page_num) {
			    $navs[] = $i;
			}
		    }
		    //下一页
		    if ($page_num != $page_total) {
			$navs[] = -3; //-3代表下一页
		    }
		    //显示navs
		    $nav_len = count($navs);
	//					print_r ($navs);
		    for ($i = 0; $i < $nav_len; $i ++) {
			$text = '';
			$href = '';
			if ($navs[$i] == -1) {
			    $text = '上一页';
			    $href = '/p/' . ($page_num - 1) . '.html';
			} elseif ($navs[$i] == -2) {
			    $text = '...';
			    $href = '#';
			} elseif ($navs[$i] == -3) {
			    $text = '下一页';
			    $href = '/p/' . ($page_num + 1) . '.html';
			} else {
			    $text = $navs[$i];
			    $href = '/p/' . $navs[$i] . '.html';
			}
			if (!empty($tag)) {
			    $href = $href . '?s=' . $tag;
			}
			echo "<li><a class='page-numbers " . ($navs[$i] == $page_num ? 'current' : '') . "' href='" . $href . "'>" . $text . "</a></li>";
		    }
		    ?>
                </ul>	
            </div>
	    <?php require_once 'parts/part.sidebar.php'; ?>
        </div><!-- #main -->
        <div id="share_weixin_box"></div>
	<?php require_once 'parts/part.footer.php'; ?>
    </body>
</html>


<!DOCTYPE html>
<?php
require_once('../inc/mysql.inc.php');
require_once('../inc/soup.inc.php');
require_once('../inc/utils.inc.php');

$num = isset($_GET['num']) ? strip_tags(mysql_escape_string($_GET['num'])) : 1;

$SoupDao = new SoupDao;
$soup = $SoupDao->findById($num);
if ($soup == null) {
	echo "<script>location.href='http://soup.setin.cn/';</script>";
	exit();
}
$nextid = $SoupDao->searchNextArticleID($num);
$preid = $SoupDao->searchPreArticleID($num);
Mysql::close();
$title = substr_ext($soup['content'], 0, 30);
$title = preg_replace("/\s/", "", $title);
$descrip = substr_ext($soup['content'], 0, 100);
$descrip = preg_replace("/\s/", "", $descrip);
?>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8" />
        <meta name="renderer" content="webkit" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta http-equiv="Cache-Control" content="no-transform " /> 
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="心灵鸡汤,<?php echo $soup['j_tag']; ?>" />
        <meta name="description" content="<?php echo $descrip; ?>" />
        <link rel="Bookmark" href="/res/joke/favicon.ico" />
        <link rel="shortcut icon" href="/res/joke/favicon.ico" />
        <title><?php echo $title; ?>... | 心灵鸡汤</title>
        <script type="text/javascript" src="/res/joke/share.js"></script>
        <link rel='stylesheet' id='joke-style-css'  href='/res/joke/jokecss.css' type='text/css' media='all' />
    </head>
    <body>
        <div id="main" class="clearfix">
            <div itemscope itemtype="http://schema.org/Article" id="content">
                <div class="panel">
                    <div class="body clearfix">
                        <a class="logo left" href="http://soup.setin.cn/" title="心灵鸡汤">心灵鸡汤</a>
                        <div>
                            <h1>
								<a href="http://soup.setin.cn/">
									<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
										<span itemprop="name">心灵鸡汤</span>
									</span>
								</a>
							</h1>
                            <p>我们不生产心灵鸡汤，我们只是心灵鸡汤的搬运工</p>
                        </div>
                    </div>
                </div>
                <p class="tips">如果喜欢这个心灵鸡汤，别忘了分享给你的朋友哦！</p>		
                <div class="panel open">
                    <div class="body" >
                        <p itemprop="articleBody"><?php echo $soup['content']; ?></p>
                    </div>
                    <div class="footer clearfix">
                        <a href="javascript:;" onclick="tags_toggle(this)" class="tags-toggle">关键词</a>
                        <script>share_output();</script>
                        <a itemprop="url" href="/<?php echo $soup['id']; ?>.html"><?php echo $soup['posttime']; ?></a>
                    </div>
                    <div class="footer tags">
						<?php
						if (isset($soup['tag'])) {
							$tags_array = explode(',', $soup['tag']);
							foreach ($tags_array as $tag_item) {
								echo "<a href='http://soup.setin.cn/?s=$tag_item'><span itemprop='articleSection'>$tag_item</span></a>、";
							}
						}
						?>
                    </div>
                </div>
                <ul class="panel nav">
                    <li><?php echo $preid[0]['id'] == '' ? '没有了' : '<a href="' . $preid[0]['id'] . '.html"' . '"rel="prev">&laquo;上一条 </a>' ?> </li>
                    <li class="home"><a href="http://soup.setin.cn/" rel="home">返回首页</a></li>
                    <li><?php echo $nextid[0]['id'] == '' ? '没有了' : '<a href="' . $nextid[0]['id'] . '.html"' . '"rel="next">下一条 &raquo;</a>' ?> </li>
                </ul>
            </div><!-- #content -->
			<?php require_once 'parts/part.sidebar.php'; ?>
        </div><!-- #main -->
        <div id="share_weixin_box"></div>
		<?php require_once 'parts/part.footer.php'; ?>
    </body>
</html>

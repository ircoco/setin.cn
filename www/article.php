<!DOCTYPE html>
<?php
require_once('../inc/mysql.inc.php');
require_once('../inc/mryw.inc.php');
require_once ('../inc/utils.inc.php');

$num = isset($_GET['num']) ? strip_tags(mysql_escape_string($_GET['num'])) : -1;

$mryw_dao = new Mryw();
if ($num == -1) {
	$mryw = $mryw_dao->get_lastest_article();
} else {
	$mryw = $mryw_dao->find_by_id($num);
}
if ($mryw == false) {
	echo "<script>location.href='http://www.setin.cn/';</script>";
	exit();
}
$num = $mryw['m_id'];

$nextid = $mryw_dao->search_next_article_id($num);
$preid = $mryw_dao->search_prev_article_id($num);
$total_num = $mryw_dao->count_all();
if ($total_num == false) {
	$total_num = 0;
}
Mysql::close();
$descrip = substr_ext(strip_tags($mryw['m_content']), 0, 100);
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
        <meta name="keywords" content="每日一文,经典美文,每日经典美文,全网最全面的美文数据库,<?php echo $mryw['m_title']; ?>,<?php echo $mryw['m_author']; ?>" />
        <meta name="description" content="每日经典美文,<?php echo $descrip; ?>" />
        <link rel="Bookmark" href="/res/mryw/favicon.ico" />
        <link rel="shortcut icon" href="/res/mryw/favicon.ico" />
		<link rel="alternate" href="http://www.setin.cn" hreflang="zh" />
        <title><?php echo $mryw['m_title']; ?>... | 每日经典美文</title>
        <link rel='stylesheet' id='joke-style-css'  href='/res/joke/jokecss.css' type='text/css' media='all' />
		<script type="text/javascript" src="/res/mryw/share.js"></script>
		<style>#main .body p {text-indent: 2em;}</style>
    </head>
    <body>
        <div itemscope itemtype="http://schema.org/Article" id="main" class="clearfix">
            <div id="content">
                <div class="panel">
                    <div class="body clearfix">
                        <a class="logo left" href="http://www.setin.cn/" title="每日经典美文">每日经典美文</a>
                        <div>
                            <h1>
								<a itemprop="url" href="http://www.setin.cn/<?php echo $mryw['m_id']; ?>.html">
									<span itemprop="name">《<?php echo $mryw['m_title']; ?>》</span> | 
									<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
										<span itemprop="name">每日经典美文</span>
									</span>
								</a>
							</h1>
                            <p>我们不生产美文，我们只是经典美文的搬运工</p>
                        </div>
                    </div>
                </div>
                <p class="tips">如果喜欢文章，别忘了分享给你的朋友哦！本站目前搬运 <?php echo $total_num; ?> 篇文章</p>		
                <div class="panel open">
                    <div class="body">
						<span itemprop="articleBody">
							<p><?php echo $mryw['m_content']; ?></p>
						</span>
                    </div>
                    <div class="footer clearfix">
                        <a href="javascript:;" onclick="tags_toggle(this)" class="tags-toggle">作者</a>
                        <script>share_output('http://www.setin.cn/<?php echo $mryw['m_id']; ?>.html', '<?php echo "《" . $mryw['m_title'] . "》 | 每日经典美文"; ?>', '<?php echo $descrip; ?>');</script>
                        <a href="#"><span itemprop="datePublished" content="<?php echo date("c", strtotime($mryw['m_time'])); ?>"><?php echo $mryw['m_time']; ?></span></a>
                    </div>
                    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
						<div itemprop="name" class="footer tags"><?php echo $mryw['m_author']; ?></div>
					</span>
                </div>
                <ul class="panel nav">
                    <li><?php echo $preid[0]['m_id'] == '' ? '没有了' : '<a href="' . $preid[0]['m_id'] . '.html"' . '"rel="prev">&laquo;上一篇 </a>' ?> </li>
                    <li class="home"><a href="http://www.setin.cn/" rel="home">返回首页</a></li>
                    <li><?php echo $nextid[0]['m_id'] == '' ? '没有了' : '<a href="' . $nextid[0]['m_id'] . '.html"' . '"rel="next">下一篇 &raquo;</a>' ?> </li>
                </ul>
            </div><!-- #content -->
			<?php require_once 'parts/part.sidebar.php'; ?>
        </div><!-- #main -->
        <div id="share_weixin_box"></div>
		<?php require_once 'parts/part.footer.php'; ?>
    </body>
</html>

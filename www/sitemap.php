<?PHP
require_once '../inc/mysql.inc.php';
require_once('../inc/mryw.inc.php');
$content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	   <url>
			<loc>http://www.setin.cn</loc>
			<lastmod>'.date('c').'</lastmod>
			<changefreq>daily</changefreq>
			<priority>1</priority>
		</url>
';
$mryw_dao = new Mryw();
$total_num = $mryw_dao->count_all_Online();
$mryw = $mryw_dao->get_lastest_article();

$mryws = $mryw_dao->select_4_sitemap();
foreach ($mryws as $item) {
	$content .= create_item($item);
}
$content .= '</urlset>';
echo $content;
Mysql::closeConn();

function create_item($data) {
    $item = "<url>\n";
    $item.="<loc>http://www.setin.cn/" . $data['m_id'] . ".html</loc>\n";
    $item.="<priority>" . 0.9. "</priority>\n";
    $item.="<lastmod>" . date("c",strtotime($data['m_time'])) . "</lastmod>\n";
    $item.="<changefreq>" .'daily'. "</changefreq>\n";
    $item.="</url>\n";
    return $item;
}

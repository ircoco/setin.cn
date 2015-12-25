<?PHP
require_once '../inc/mysql.inc.php';
require_once('../inc/joke.inc.php');
$content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	   <url>
			<loc>http://joke.setin.cn</loc>
			<lastmod>'.date('c').'</lastmod>
			<changefreq>daily</changefreq>
			<priority>1</priority>
		</url>
';
$Joke_dao = new Joke();
$total_num = $Joke_dao->count_online("");


$jokes = $Joke_dao->select_4_sitemap();
foreach ($jokes as $item) {
	$content .= create_item($item);
}
$content .= '</urlset>';
echo $content;
Mysql::closeConn();

function create_item($data) {
    $item = "<url>\n";
    $item.="<loc>http://joke.setin.cn/" . $data['j_id'] . ".html</loc>\n";
    $item.="<priority>" . 0.9. "</priority>\n";
    $item.="<lastmod>" . date("c",strtotime($data['j_time'])) . "</lastmod>\n";
    $item.="<changefreq>" .'daily'. "</changefreq>\n";
    $item.="</url>\n";
    return $item;
}

<?php
define("TOKEN", "yixin");
define('DEBUG', false);

include_once 'config.inc.php';
include_once 'mysql.inc.php';
include_once 'weixinUser.inc.php';

include_once 'yixin.class.php';
include_once 'mryw.inc.php';//1
include_once 'joke.inc.php';//2
include_once 'beautiful.inc.php';//3
include_once 'robot.inc.php';//4
include_once 'weather.inc.php';//5
include_once 'youdaoTrans.inc.php';//6
include_once 'mobile.inc.php';//7
include_once 'smsbomb.inc.php';//hzj

include_once 'UserState.php';
$yixin = new YiXin(TOKEN, DEBUG);
//valid
$is_valid = false;
if (isset($_GET["echostr"])) {
	$is_valid = true;
}	
if ($is_valid) {
	$yixin->valid();
	exit(0);
}
//正常模式
$yixin->getMsg();

$type = $yixin->msgtype; // 消息类型

$reply = "";

if ($type === 'event') {
  	$event = $yixin->msg['Event'];
  	if ($event === 'CLICK') {
		// 事件
		if ($yixin->msg['EventKey'] === 'about') {
			$reply = $yixin->makeText("欢迎访问 红色石头[http://50vip.com]，我是王小为，我为自己带酱油！");
		} elseif ($yixin->msg['EventKey'] === 'mryw') {
			$reply = chooseFunctionNum('1', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'joke') {
			$reply = chooseFunctionNum('2', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'soup') {
			$reply = chooseFunctionNum('3', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'robot') {
			$reply = chooseFunctionNum('4', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'weather') {
			$reply = chooseFunctionNum('5', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'youdao_trans') {
			$reply = chooseFunctionNum('6', $yixin);
		} elseif ($yixin->msg['EventKey'] === 'mobile') {
			$reply = chooseFunctionNum('7', $yixin);
		} else {
			$reply = $yixin->makeText("未定义的菜单事件...");
		}
    }
  	elseif ($event === 'subscribe') {
    	$reply = $yixin->makeText(cons::$WELCOME_STR);
  	}
  	elseif ($event === 'unsubscribe') {
    	$reply = $yixin->makeText(cons::$LEAVE_STR);
  	}
	else {
		$reply = $yixin->makeText("未定义的事件...");
    }
} elseif ($type === 'text') {
	$keyword = $yixin->msg ['Content']; // 用户的文本消息内容
	$state = UserState::getUserState($yixin->msg ['FromUserName']);
	if ($keyword == 'Hello2BizUser') {
		$reply = $yixin->makeText(cons::$WELCOME_STR);
	} // 返回上机
	elseif ($keyword == 'q' || $keyword == 'Q') {
		UserState::setUserState($yixin->msg ['FromUserName'], '0', '');
		$reply = $yixin->makeText(cons::$WELCOME_STR);
	} 
    else {
		// 主界面
		if ($state ['state'] == '0') {
			$reply = chooseFunctionNum($keyword, $yixin);
		}   // mryw
		elseif ($state ['state'] == '1') {
			$mryw = new Mryw($keyword);
			$rst = $mryw->get();
            $reply = $yixin->makeNews($rst);
		}   // joke
		elseif ($state ['state'] == '2') {
			$joke = new Joke($keyword);
			$rst = $joke->getJoke();
            $reply = $yixin->makeNews($rst);
		}  // mm
		elseif ($state ['state'] == '3') {
			$beautiful = new Beautiful($keyword);
            $rst = $beautiful->getBeautifulPic();
            $reply = $yixin->makeNews($rst);
		} //机器人
		elseif ($state ['state'] == '4') {
			$robot = new Robot($keyword);
            $rst = $robot->getReply();
            if(is_array($rst)) {
				$reply = $yixin->makeNews($rst);
            }
            else {
            	$reply = $yixin->makeText($rst);
            }
		}  //天气
		elseif ($state ['state'] == '5') {
			
			$weather = new Weather($keyword);
			$reply = $yixin->makeText($weather->getWeatherDetail());
		}  //翻译
		elseif ($state ['state'] == '6') {
			$youdao = new YouDaoTrans($keyword);
			$reply = $yixin->makeText($youdao->getTransContent());
			
		}  //手机号
		elseif ($state ['state'] == '7') {
			$mobile = new Mobile($keyword);
			$reply = $yixin->makeText($mobile->getMobileLocation());
		}
		
		//hzj
		elseif ($state ['state'] == 'hzj') {
			$smsbomb = new Smsbomb($keyword);
			$reply = $yixin->makeText($smsbomb->get());
		}
        //调试
		elseif ($state ['state'] == '100') {
			$content = $yixin->msg [FromUserName] . "\n" . $yixin->msg [ToUserName];
			$reply = $yixin->makeText($content);
		} else {
			$reply = $yixin->makeText(cons::$WELCOME_STR);
		}
	}
} elseif ($type === 'location') {
	// 用户发送的是位置信息 稍后的文章中会处理
} elseif ($type === 'image') {
	// 用户发送的是图片 稍后的文章中会处理
} elseif ($type === 'voice') {
	// 用户发送的是声音 稍后的文章中会处理
}
$yixin->reply($reply);

function chooseFunctionNum($keyword, $yixin) {
	$reply = '';
	if (key_exists($keyword, cons::$FUNCTION_STR_ARRAY)) {
		$reply = $yixin->makeText(cons::$FUNCTION_STR_ARRAY[$keyword]);
		UserState::setUserState($yixin->msg ['FromUserName'], $keyword, '');
	}
	//其他不合法功能
	else {
		$reply = $yixin->makeText(cons::$WELCOME_STR);
	}
	return $reply;
}

?>
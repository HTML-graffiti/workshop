<?php

mb_language("ja");
mb_internal_encoding("UTF-8");

//var_dump($_POST);

// 変数の初期化
$page_flag = 0;

if( !empty($_POST['btn_confirm']) ) {
	$page_flag = 1;
	// セッションの書き込み
	session_start();
	$_SESSION['page'] = true;

} elseif( !empty($_POST['btn_submit']) ) {
	session_start();
	if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

	// セッションの削除
	unset($_SESSION['page']);

	$page_flag = 2;

	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	// ヘッダー情報を設定
	$header = "MIME-Version: 1.0\n";
	$header .= "From: ∧°┐ <we.are.pe.hu@gmail.com>\n";
	$header .= "Reply-To: ∧°┐ <we.are.pe.hu@gmail.com>\n";

	// 件名を設定
	$auto_reply_subject = 'How to Coding | HTML graffiti';

	// 本文を設定
	$auto_reply_text .= "ワークショップのご予約を承りました。\n";
	$auto_reply_text .= "近日中にご返信します。今しばらくお待ちください。\n\n";
	$auto_reply_text .= "あなたの名前\n" . $_POST['name'] . "\n\n";
	$auto_reply_text .= "ワークショップを希望する日時\n" . $_POST['date'] .  " ";
	$auto_reply_text .= " ". $_POST['time'] . "\n\n\n";
	$auto_reply_text .= "希望するワークショップ\n\nHTMLの基本 : " . nl2br($_POST['html']) . "\n\n";
	$auto_reply_text .= "CSSの基本 : " . nl2br($_POST['css']) . "\n\n";
	$auto_reply_text .= "備考\n" . nl2br($_POST['contact']) . "\n\n\n";
	$auto_reply_text .= "Posted on " . date("m-d-Y H:i") . "\n";
	$auto_reply_text .= "creative-community.space/coding/";

	// メール送信
	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

	// 運営側へ送るメールの件名
	$admin_reply_subject = "How to Coding | HTML graffiti";

	// 本文を設定
	$admin_reply_text .= "How to Coding | HTML graffiti\n\n\n";
	$admin_reply_text .= "名前\n" . $_POST['name'] . "\n";
	$admin_reply_text .= "メールアドレス\n" . $_POST['email'] . "\n\n";
	$admin_reply_text .= "ワークショップを希望する日時\n" . $_POST['date'] .  " ";
	$admin_reply_text .= " ". $_POST['time'] . "\n\n\n";
	$admin_reply_text .= "HTMLの基本" . nl2br($_POST['html']) . "\n";
	$admin_reply_text .= "CSSの基本" . nl2br($_POST['css']) . "\n\n";
	$admin_reply_text .= " " . nl2br($_POST['contact']) . "\n\n\n";
	$admin_reply_text .= "Posted on " . date("m-d-Y H:i") . "\n";
	$admin_reply_text .= "creative-community.space/coding/";

	// 運営側へメール送信
	mb_send_mail( 'pehu@creative-community.space', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>How to Coding | HTML graffiti</title>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://creative-community.space/coding/submit/form.css"/>
<style type="text/css">

        @font-face {
            font-family: "NewYork";
            src: url("https://creative-community.space/coding/fontbook/NewYork.otf");
        }

html,
#form input[type="date"],
#form input[type="name"],
#form input[type="text"],
#form input[type="url"],
#form input[type="email"],
#form input[type="reset"],
#form input[type="password"],
#form input[type="submit"],
#form textarea,
#form button,
#form select,
#form .radio,
h1 {
    font-family: "NewYork", serif;
}

hr {
	border:none;
	padding:1rem;
}

h1 {
    font-weight: 500;
    font-stretch: condensed;
    font-variant: common-ligatures tabular-nums;
    transform: scale(1, 1.1);
    letter-spacing: -0.1rem;
    word-spacing: -.1ch;
}

a {
	color:#ccc;
	margin: 2rem 0 0;
	text-decoration: none;
}
a:hover {
	color:#000;
	text-decoration: #ccc wavy underline;
	cursor: pointer;
}

#contents {
	border-bottom: 1px dashed #ccc;
}

#contents #main {
	font-size:1rem;
}
#contents #main p {width:auto; display:block;}
#contents #confirm {
  width:100%;
  display: flex;
  flex-direction: row;
}
#contents #confirm p {
  font-size:2.5vw;
  display:inline-block;
  padding:1.25% 2.5%;
  width:45%;
}
#contents #confirm h2 {font-size:4vw; padding:0 2.5%;}
#main h1, #hello h1 {font-size:2rem; padding:0 2.5%;}
#contents p, #form p, #form h1  {padding:0 2.5%;}
#contents #hello,
#contents #comment,
#contents #next {
  display:block;
  clear:both;
  font-size:2.5vw;
  padding:1.25% 2.5%;
  width:90%;
}
#contents #comment {
  border:1px solid;
  border-radius:2vw;
  margin:auto;
  }
</style>
</head>
<body>
<div id="contents">
<div id="main">
<p>How to Coding | HTML graffiti</p>
<h1>Online Workshop</h1>
</div>
</div>
<div id="form">
<?php if( $page_flag === 1 ): ?>

<form action="" method="post">
<div id="contents">
<div id="confirm">
<p>名前<br/><b><?php echo $_POST['name']; ?></b></p>
<p>メールアドレス<br/><b><?php echo $_POST['email']; ?></b></p>
</div>
<div id="confirm">
<p><u>ワークショップを希望する日時</u></p>
<h2>
<?php echo $_POST['date']; ?>　<?php echo $_POST['time']; ?>
</h2>
</div>
<div id="comment">
<p>HTMLの基本 <?php echo ($_POST['html']); ?></p>
<p>CSSの基本 <?php echo ($_POST['css']); ?></p>
<p><?php echo nl2br($_POST['contact']); ?></p>
</div>

<p id="next">
<input type="submit" name="btn_back" value="修正">
<input type="submit" name="btn_submit" value="送信">
</p>

<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
<input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
<input type="hidden" name="time" value="<?php echo $_POST['time']; ?>">
<input type="hidden" name="html" value="<?php echo $_POST['html']; ?>">
<input type="hidden" name="css" value="<?php echo $_POST['css']; ?>">
<input type="hidden" name="contact" value="<?php echo $_POST['contact']; ?>">
</div>
</form>

<?php elseif( $page_flag === 2 ): ?>
<div id="contents">
<div id="hello">
<h1 class="fontmotion">ワークショップへのご予約を承りました。</h1>
<p>フォームに入力いただいたメールアドレスまで、ご予約内容を自動返信いたします。<br/>自動返信メールが届かなかった場合は、お手数ですが、pehu@creative-community.space まで改めてご連絡ください。</p>
<p><a href="/org/">creative-community-space/org/</a></p>
<br/>
</div>
</div>

<?php else: ?>
<section>
<p>準備中</p>
<p>Links | 
	<a href="/coding/" target="_blank">How to Coding</a> | 
</p>
<hr/>
<h1>ワークショップを予約する</h1>
<form action="" method="post">
<input id="name" type="name" name="name" placeholder="あなたの名前" value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>" required>
<input id="email" type="email" name="email" placeholder="メールアドレス" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>" required>
<hr/>
<h1>ワークショップを希望する日時</h1>
<input type="date" name="date" value="<?php if( !empty($_POST['date']) ){ echo $_POST['date']; } ?>" required><br/>
<input id="time" type="text" name="time" placeholder="ワークショップ希望開始時間" value="<?php if( !empty($_POST['time']) ){ echo $_POST['time']; } ?>" required>
</hr>
<p><br/><u>希望するワークショップ</u><br/></p>
<p>HTMLの基本（所要時間：約1時間）<br/>
<select name="html">
<option value="無回答">- 選択する -</option>
<option value="希望する">希望する</option>
<option value="希望しない">希望しない</option>
</select>
</p>

<p>CSSの基本（所要時間：約1時間）<br/>
<select name="css">
<option value="無回答">- 選択する -</option>
<option value="希望する">希望する</option>
<option value="希望しない">希望しない</option>
</select>
</p>

<textarea name="contact" placeholder="備考" required><?php if( !empty($_POST['contact']) ){ echo $_POST['contact']; } ?></textarea>
<p><input type="submit" name="btn_confirm" value="確認する"></p>
</form>
</section>
<?php endif; ?>

</div>
</body>
</html>

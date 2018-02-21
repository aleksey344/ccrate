<?php
    session_start();
    if (!isset($_COOKIE['session_key'])) {
        setcookie("session_key", session_id());
        $_COOKIE['session_key'] = session_id();
        //echo('Кук создан<br>');
    }

    $sitedonor='http://3aindex.ru';
require_once 'overrides.php';
// проверяем Action на значения /?action=createportfel или /?action=loadcalcinemail
  $action='';
  if (isset($_REQUEST['action'])) {
     $action=$_REQUEST['action'];
     //echo($_REQUEST['action'].'<br>');
     //exit;
  }
  if ($action=='createsubscription') {
    if (isset($_REQUEST['mail'])||isset($_REQUEST['name'])) {
      $code_email = base64_encode(htmlspecialchars(strtolower($_REQUEST['mail'])));
      $code_name = base64_encode(htmlspecialchars($_REQUEST['name']));
      $contents='';
      $count=0;
      while ($contents == '') {
        if ($count>5) {
          break;
        }
        $file = $sitedonor."/json.php?code={sgXdYvgL&action=linkseskeyemail&mail=".$code_email."&name=".$code_name."&session_key=".base64_encode(htmlspecialchars($_COOKIE['session_key']));

//        echo($file.'<br>');
        $contents = file_get_curl($file);
//        $handle = fopen($file, "r");
      //  $handle = fopen('./cache_curs.json','r');
//        $contents = fread($handle, 5*1024*1024);
//        fclose($handle);
        $count = $count + 1;
      }
      $json = json_decode($contents,true);

      // отправляем письмо
      $to  = "vashcryptoguru@gmail.com" ;

      $subject = "Новая подписка с сайта http://ccrate.ru/#subscription";

      $message = '
      <html>
          <head>
              <title>Новая подписка с сайта http://ccrate.ru/#subscription</title>
          </head>
          <body>
              <p>Имя подписчика: '.htmlspecialchars($_REQUEST['name']).' . </p>
              <p>Почта подписчика: '.htmlspecialchars($_REQUEST['mail']).' . </p>
          </body>
      </html>';

      $headers  = "Content-type: text/html; charset=UTF-8 \r\n";

      mail($to, $subject, $message, $headers);

  /*      echo('<pre>');
        print_r($json);
        echo('</pre>');
        exit;*/
    }
  }
//
  if ($action=='loadcalcinemail') {
    if (isset($_REQUEST['mail'])) {
      $code_email = base64_encode(htmlspecialchars(strtolower($_REQUEST['mail'])));
      $contents='';
      $count=0;
      while ($contents == '') {
        if ($count>5) {
          break;
        }
        $file = $sitedonor."/json.php?code={sgXdYvgL&action=linkseskeyemail&mail=".$code_email."&session_key=".base64_encode(htmlspecialchars($_COOKIE['session_key']));

//        echo($file.'<br>');
        $contents = file_get_curl($file);
//        $handle = fopen($file, "r");
      //  $handle = fopen('./cache_curs.json','r');
//        $contents = fread($handle, 5*1024*1024);
//        fclose($handle);
        $count = $count + 1;
      }
      $json = json_decode($contents,true);
  /*      echo('<pre>');
        print_r($json);
        echo('</pre>');
        exit;*/
    }
  }
  if ($action=='createportfel') {
      $vars='';
      $code_email = base64_encode(htmlspecialchars(strtolower($_REQUEST['email'])));
      $file = $sitedonor."/json.php?code={sgXdYvgL&action=linkseskeyemail&mail=".$code_email."&session_key=".base64_encode(htmlspecialchars($_COOKIE['session_key']));
      $contents = file_get_curl($file);

      foreach ($_REQUEST['namecurid'] as $key => $value) {
        $vars=$vars.'&namecurid['.$key.']='.$value.'&count['.$key.']='.$_REQUEST['count'][$key];
      }
      $code_email = base64_encode(htmlspecialchars(strtolower($_REQUEST['email'])));
      $file = $sitedonor."/json.php?code={sgXdYvgL&action=createportfel&mail=".$code_email."&session_key=".base64_encode(htmlspecialchars($_COOKIE['session_key'])).$vars;
      $contents = file_get_curl($file);

      //$handle = fopen($file, "r");
      //$contents = fread($handle, 5*1024*1024);
      //fclose($handle);
      //echo($contents);
/*          echo('namecurid<br><pre>');
          print_r($_REQUEST['namecurid']);
          echo('</pre>');
          echo('count<br><pre>');
          print_r($_REQUEST['count']);
          echo('</pre>');
*/

  /*      echo('<pre>');
        print_r($json);
        echo('</pre>');
        exit;*/
  }

	require_once 'cc-charts/ajax.php';
  $contents='';
  $count=0;
  while ($contents == '') {
    if ($count>5) {
      break;
    }
    $file = $sitedonor."/json.php?code={sgXdYvgL&action=getcalcportfel&session_key=".base64_encode(htmlspecialchars($_COOKIE['session_key']));
    $contents = file_get_curl($file);

//    echo ($file.'<br>');
//    $handle = fopen($file, "r");
  //  $handle = fopen('./cache_curs.json','r');
//    $contents = fread($handle, 5*1024*1024);
//    fclose($handle);
    $count = $count + 1;
    $json = json_decode($contents,true);
  /*        echo('<pre>');
          print_r($json);
          echo('</pre>');
          exit; */
    if($json)
    {
      $json_count = count($json);
      if($json_count > 0)
      {
        break;
      }
    }
  }


  if (isset($json['email'])) {
    $json['email'] = base64_decode($json['email']);
  }
/*  echo('<pre>');
  print_r($json);
  echo('</pre>');
  exit;*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Title</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- FONT AWESOME -->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <!-- GOOGLE FONTS ################### -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">

    <!-- MY CSS STYLE ###################### -->
    <link rel="stylesheet" href="css/style.css">
      <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113139169-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-113139169-4');
  </script>

<link rel="stylesheet" type="text/css" href="cc-charts/assets/vendor/select2/css/select2.min.css" />
<link rel="stylesheet" type="text/css" href="cc-charts/assets/vendor/amstock/plugins/export/export.css" />
<link rel="stylesheet" type="text/css" href="cc-charts/assets/css/style.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
<script src="cc-charts/assets/vendor/amstock/amcharts.js"></script>
<script src="cc-charts/assets/vendor/amstock/serial.js"></script>
<script src="cc-charts/assets/vendor/amstock/amstock.js"></script>
<script src="cc-charts/assets/vendor/amstock/plugins/export/export.min.js"></script>
<script src="cc-charts/assets/vendor/select2/js/select2.full.js"></script>
<script src="cc-charts/assets/js/app.min.js"></script>

<script src="js/jquery.mask.js"></script>


<script type="text/javascript">
  var url = "http://ccrate.ru"; //Адрес Вашего сайта
  var title = "Курсы криптовалют"; //Название Вашего сайта
  function addFavorite(a) {
    try {
      window.external.AddFavorite(url, title);
    }
    catch (e) {
      try {
        window.sidebar.addPanel (title, url, "");
        }
      catch (e) {
        if (typeof(opera)=="object") {
          a.rel = "sidebar";
          a.title = title;
          a.url = url;
          return true;
        }
        else {
          alert("Нажмите Ctrl-D для добавления в избранное");
        }
      }
    }
    return false;
          }
</script>
<script>
function addrow ()
      {
        var tbody = document.getElementById("dynamic"); // Получаем ссылку на tbody

        var val_id = document.getElementById("selectspisok").options[document.getElementById("selectspisok").options.selectedIndex].value;
        var val = document.getElementById("selectspisok").options[document.getElementById("selectspisok").options.selectedIndex].text;

//        var val = n.value;
        var countinput = document.getElementById("inputcount").value;
        var costusd ='';
        var costusd = countinput*document.getElementById("selectspisok").options[document.getElementById("selectspisok").options.selectedIndex].getAttribute('data-cost');

        var kursBTCinUSD = <? echo($json['kursBTCinUSD']==''?0:number_format($json['kursBTCinUSD'],5,'.','')); ?>;
        var costbtc = 0;
        if (kursBTCinUSD!=0) {
          var costbtc = costusd/kursBTCinUSD;
        };



        if (countinput!='') {
          //var row = tbody.insertRow(tbody.rows.length); // Добавляем строку
          var row = tbody.insertRow(0); // Добавляем строку
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          var cell6 = row.insertCell(5);
          var cell7 = row.insertCell(6);

          // Формируем строку элементов управления
          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "text");
          check.setAttribute("name", "namecur["+tbody.rows.length+"]");
          check.setAttribute("class", "input_border");
          check.setAttribute("value", val);
          check.setAttribute("readonly","");
          cell1.appendChild(check);

          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "hidden");
          check.setAttribute("name", "namecurid["+tbody.rows.length+"]");
          check.setAttribute("class", "input_border");
          check.setAttribute("value", val_id);
          check.setAttribute("readonly","");
          cell6.appendChild(check);

          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "number");
          check.setAttribute("name", "count["+tbody.rows.length+"]");
          check.setAttribute("class", "input_border");
          check.setAttribute("value", countinput);
          check.setAttribute("readonly","");
          check.setAttribute("placeholder","КОЛИЧЕСТВО");
          check.setAttribute("step","any");
          cell2.appendChild(check);

          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "text");
          check.setAttribute("name", "costusd["+tbody.rows.length+"]");
          check.setAttribute("class", "input_border");
          check.setAttribute("value", "$ "+costusd);
          check.setAttribute("readonly","");
          cell3.appendChild(check);

          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "text");
          check.setAttribute("name", "costbtc["+tbody.rows.length+"]");
          check.setAttribute("class", "input_border");
          check.setAttribute("value", costbtc);
          check.setAttribute("readonly","");
          cell4.appendChild(check);

          var check = document.createElement("input"); // Ввод файла
          check.setAttribute("type", "button");
          check.setAttribute("name", "action["+tbody.rows.length+"]");
          check.setAttribute("class", "del input_border");
          check.setAttribute("style","background-color: white; color: rgb(70, 86, 167);");
          check.setAttribute("value", "УДАЛИТЬ");//border-bottom-color:
          cell5.appendChild(check);

          //tbody.insertBefore(row, tbody.firstChild);
          tbody.appendChild(row);
        }

      }
</script>

<!-- Facebook Pixel Code -->

<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=173152869966987&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  </head>
  <body>
<header class="main-nav scroller fixed" style="
    height: 75px;
">
    	<div class="container">
    		<div class="row" style="
    height: 75px;
">
    			<div class="logo col-md-2 col-sm-2"><img src="img/logo.png" alt=""></div>
    			<nav class="col-md-7 col-sm-10">
    				<ul>
    					<li><a href="#one">Главная</a></li>
    					<li><a href="#two">Портфель</a></li>
    					<li><a href="#six">Подписка</a></li>
    					<li><a href="documents.html">Обо мне</a></li>
    				</ul>
    			</nav>
    		</div>
    	</div>
    </header>

    <section id="one">
    	<div class="container">
    		<div class="row mb" style="margin-bottom: 5px; ">
    			<div class="one__box col-md-12" style="margin-bottom: 5px;">
    				<div class="one__header">Графики</div>
    			</div>
    		</div>
    		<div class="row">


    			<!-- here -->
				<div class="col-md-8 col-md-offset-2 before__header">
					<p>Предлагаем вашему вниманию инструмент отслеживания динамики курсов различных криптовалют. Изменение динамики происходит автоматически. График позволяет оценить сравнительной изменение курсов нескольких валют. Для этого вам в окошке валюты необходимо вобрать соответствующие наименование. Вы можете сохранить график и данные в выбранном формате, воспользовавшись кнопкой скачать.  Данный инструмент предоставляется бесплатно. Буду благодарен за ссылку. Вы так же можете подписаться на новости портала и рынка криптовалют (форма ниже).</p>
				</div>
				<!-- here -->


    			<div class="one__table mmr" style="padding-top: 10px;">
				<center><table style="text-align: left; width: 800px;" border="0" cellpadding="2" cellspacing="0">
  <tbody>
    <tr>
      <td style="width: 800px;"></td></tr>
<tr>
      <td style="width: 800px;"><div id="my-cc-chart" class="ccc-chart-container"></div>
<script>
  cryptocurrencyChartsPlugin.buildChart(
    'my-cc-chart', // HTML container ID
    1182, // ID of cryptocurrency (see full list below)
    'USD', // display currency
    {
      primaryChartType: "smoothedLine",
      secondaryChartType: "column",
      primaryLineColor: "red",
      width: "800",
      height: "400px"
    }, // settings
    'assets/images/coins/7777-ATOP.png' // path to background image logo
  );
</script></td>
    </tr>
  </tbody>
</table></center>


    			</div>
    		</div>
    	</div>
    </section>
  <a name="calc"></a>
 <section id="two">
    	<div class="container">
    		<div class="row mb" style="margin-bottom: 5px; margin-top: 170px;">
    			<div class="one__box one__box_expert col-md-12" style="margin-bottom: 5px;">
    				<div class="one__header one__header_expert">Калькулятор портфеля</div>
    			</div>
    		</div>
    		<div class="row">

    			<!-- <div class="one__table mmr" style="padding: 5px 0 20px;">
				<center>
				    <div style="text-align: left; width: 800px; margin-bottom: 15px;">Текст
подписки ... Текст подписки ... Текст подписки ... Текст подписки ...
Текст подписки ... Текст подписки ... Текст подписки ... Текст подписки
... Текст подписки ... Текст подписки ... Текст подписки ... Текст
подписки ТОЧКА</div> -->

			<div class="col-md-8 col-md-offset-2 before__header">
					<p>Предлагаем вашему вниманию инструмент оценки стоимости портфеля криптовалют. Вам необходимо добавить позиции с суммами и наименованием криптовалют. После чего добавить емайл и произвести расчет (ваш емайл необходим, что бы зайдя на сайт в следующий раз ваш портфель погрузился автоматически даже если в ы почистили куки). Данный инструмент предоставляется бесплатно.</p>
					<p>
						В дальнейшем мы будем развивать функционал данного инструмента. В соответствии с вашими пожеланиями, можете формулировать их в телеграмме, в твиттере, или Фейсбу́к. Буду благодарен за ссылку. Вы так же можете подписаться на новости портала и рынка криптовалют (форма ниже).
					</p>
				</div>
<form name="form_calc_load" action="/#calc" method="post">
  <table style="text-align: left; align:left; width: 800px;" border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="text-align: right;" colspan="7"
 rowspan="1"><span style="font-weight: bold;">Если
Вы добавили Ваш портфель,
введите Ваш e-mail</span><br><br>
      <input name="mail" style="width:300px" required size="40" value="<?echo($json['email'])?>" placeholder="Ваш e-mail" type="email">
      <input name="action" value="loadcalcinemail" type="hidden">
 <input style="background-color: rgb(40, 49, 88); color: white;" value=" Загрузить портфель " type="submit">
      </td>
    </tr>
    <tr><td colspan="7"
 rowspan="1">&nbsp;</td></tr>
</tbody></table>
</form>
<form name="form_calc_add" action="#">
<table style="text-align: left; align:left; width: 800px;" border="0" cellpadding="2" cellspacing="2">
<tbody>
    <tr>
      <td style="width:150px;">
      <select id="selectspisok" name="spisok">
      <?
      // <option selected value="">ВАЛЮТА</option>
      foreach ($json['ListCurrency'] as $key => $value) {
        //  echo('<option value="'.$key.'">'.$value['longName'].' ('.$value['shortName'].') '.(isset($value['KursInUSD'])?'= $'.$value['KursInUSD']:'').'</option>');
        if (!isset($value['KursInUSD']) || ($value['KursInUSD']==0) ) {
          continue;
        }
        echo('<option value="'.$key.'" data-id="'.$key.'" data-cost="'.(isset($value['KursInUSD'])?number_format($value['KursInUSD'],5,'.',''):'0').'">'.$value['shortName'].'</option>');

      }
      ?>
      </select>
      </td>
      <td  style="width:150px;"><input id="inputcount" required class="money" type="number" placeholder="КОЛИЧЕСТВО" name="kol-vo" step="any"></td>
      <td  style="width:150px;"><input name=" "
 style="background-color: rgb(40, 49, 88); color: white;"
 value="ДОБАВИТЬ" type="button"  onclick="addrow ();"></td>
      <td style="width:150px;">&nbsp;</td>
      <td style="width:150px;">&nbsp;</td>
      <td></td>
      <td></td>
    </tr>
    <tr><td colspan="7" rowspan="1">&nbsp;</td></tr>
    <tr><td colspan="7" rowspan="1">&nbsp;</td></tr>
  </tbody></table>
  <script>
document.getElementById('inputcount').onkeypress = function (e) {
  return !(/[А-Яа-яA-Za-z \^\%\$\#\@\&\*]/.test(String.fromCharCode(e.charCode)));
//return (/^[0-9]+\.[0-9]$/.test(String.fromCharCode(e.charCode)));

}
</script>
</form>
<form name="form_calc_create" action="/#calc" method="post">
  <table id="dynamictab" style="text-align: left; align:left; width: 800px;" border="0" cellpadding="2" cellspacing="2">
  <thead>
    <tr style="border-bottom-style:solid; border-bottom-color: rgb(70, 86, 167); border-bottom-width:3px;">
      <td style="width:150px;">&nbsp;</td>
      <td style="width:150px;">&nbsp; </td>
      <td style="width:150px;">Стоимость в USD</td>
      <td style="width:150px;">Стоимость в BTC</td>
      <td style="width:150px;">&nbsp;</td>
      <td></td>
      <td></td>
    </tr>
    </thead>
    <tbody id="dynamic">
      <tr><td colspan="7" rowspan="1"></td></tr>
        <?
        if (isset($json['portfel'])) {
          $num = 1;
          foreach ($json['portfel'] as $key => $value) {
              if (in_array($key,array('SumUSD','SumBTC'))) {
                continue;
              }
              echo ('<tr><td><input name="namecur['.$num.']" class="input_border" value="'.$value['nameCurrency'].'" readonly="" type="text"> </td>');
?>

              <td><input name="count[<?echo($num);?>]" class="input_border" value="<?echo(number_format($value['countCurrencies'],2,'.',''));?>" readonly="" placeholder="КОЛИЧЕСТВО" step="any" type="number"> </td>
              <td><input name="costusd[<?echo($num);?>]" class="input_border" value="<?echo('$ '.number_format($value['CostUSD'],2,'.',' '));?>" readonly="" type="text"></td>
              <td><input name="costbtc[<?echo($num);?>]" class="input_border" value="<?echo(number_format($value['CostBTC'],4,'.',' '));?>" readonly="" type="text"></td>
              <td><input name="action[<?echo($num);?>]" class="del input_border" style="background-color: white; color: rgb(70, 86, 167);" value="УДАЛИТЬ" type="button"></td>
              <td><input name="namecurid[<?echo($num);?>]" class="input_border" value="<?echo($value['IdCurrenciesPair']);?>" readonly="" type="hidden"></td>
            </tr>
<?
            $num++;
          }
        }
  /*

<tr><td colspan="7" rowspan="1">&nbsp;</td></tr>
        foreach ($json['ListCurrency'] as $key => $value) {
          if (!isset($value['KursInUSD']) || ($value['KursInUSD']==0) ) {
            continue;
          }
          echo('<option value="'.$key.'" data-id="'.$key.'" data-cost="'.(isset($value['KursInUSD'])?number_format($value['KursInUSD'],5,'.',''):'0').'">'.$value['shortName'].'</option>');

        }*/
        ?>
      </tbody></table>
      <table style="text-align: left; align:left; width: 800px;" border="0" cellpadding="2" cellspacing="2">
        <tr><td colspan="7"
        rowspan="1">&nbsp;</td></tr>
    <tr align="right">
      <td colspan="7" rowspan="1"><span
 style="font-weight: bold;">Введите Ваш e-mail и сохраните
портфель</span><br><br>
      <input name="email" style="width:300px" required size="40" value="<?echo($json['email'])?>" placeholder="Ваш e-mail" type="email">
      <input name="action" value="createportfel"  type="hidden">
      <input
 style="background-color: rgb(40, 49, 88); color: white; width:200px;"
 value=" Сохранить и расчитать " type="submit">
      </td>
    </tr>
        <tr align="center">
    <td style="width: 700px;" colspan="7">
    <br><br>
<div align="center" style="width: 500px;">Стоимость Вашего портфеля на <?echo(date('d.m.Y',$json['date']));?>:</div>

      <?
        if (isset($json['portfel'])) {
          ?>
          <input name="USD" style="width: 300px; border-style:none none none none;" value="Стоимость в USD = $ <?=number_format($json['portfel']['SumUSD'],2,'.',' ')?>">

          <input name="BTC" style="width: 300px;  border-style:none none none none;" value="Стоимость в BTC = <?=number_format($json['portfel']['SumBTC'],4,'.',' ')?>">

      <?
        }
      ?>
    </td>
    </tr>
  </tbody>
</table>
</form>

</center>


    			</div>
    		</div>
    	</div>
    </section>

    <a name="subscription"></a>
	<section id="four" class="section__same">
    	<div class="container">
    		<div class="row">
			<div class="one__box col-md-12">
    				<div class="one__header">Подписка</div>
    			</div>
    			<!-- <div class="two__header">
    				<center><p>Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  Текст подписки ...  </p><center>
    			</div> -->
    		</div>
    		<div class="row">
				<div class="col-md-8 col-md-offset-2 before__header">
					<p>Мы планируем к запуску, еженедельные обзоры рынка криптовалют, мы будем предоставлять фундаментальные новости рынка касательно технических аспектов отдельных валют, новости регулирования, нахождения новых уязвимостей и багов у элементов инфраструктуры рынка. Вы можете подписаться на рассылку используя форму ниже.</p>
				</div>

    		</div>
    		<div class="row">
    			<div class="one__table one__table_f mmr col-md-8 col-md-offset-2">
<form  action="/#subscription" method="post" name="formsubscription">
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td><input name="name" type="text" size="40" required placeholder="Ваше имя"> </input></td>
      <td><input name="mail" style="width:300px" required value="<?echo($json['email'])?>" placeholder="Ваш e-mail" type="email" size="40"> </input></td>
      <td><input name="action" value="createsubscription" type="hidden">
      <input style="background-color: rgb(40, 49, 88); color: white;" value=" ОТПРАВИТЬ " type="submit"></td>

    </tr>
  </tbody>
</table>
</form>
<? /* 				<div style="width:800px;" class="col-md-8 col-md-offset-2">
<form  action="/#subscription" method="post" name="formsubscription">
					<input name="name" type="text" size="40" required placeholder="Ваше имя"> </input>
<input name="mail" style="width:200px" required value="<?echo($json['email'])?>" placeholder="Ваш e-mail" type="email" size="40"> </input>
<input name="action" value="createsubscription" type="hidden">
<input style="background-color: rgb(40, 49, 88); color: white;" value=" ОТПРАВИТЬ " type="submit">
</form>
<?//<input type="button"  style=" background-color:  #283158; color: white;" value=" ОТПРАВИТЬ "> </button>
?>
				</div> */ ?>
    			</div>


    	</div>
    </section>

    <section id="five">
    	<div class="container">

    		<div class="row">
    			<div class="col-md-2 footer__image">
    			</div>
    			<div class="col-md-10 footer__text">
    				<div class="row gd">
    					<div class="col-md-4">
    						Петров Алексей <br> <span>Эксперт, консультант, криптоинвестор</span>
    					</div>
    					<div class="col-md-2 col-md-offset-6">
    						<a href="https://business.facebook.com/vashcryptoguru"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
    						<a href="https://twitter.com/VashCryptoGuru"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    						<a class="soc_links" href="https://t.me/VashCryptoGuru"><i class="fa fa-telegram" aria-hidden="true"></i></a>
    					</div>
    				</div>
    				<div class="row gl">
    					<p>Данный проект, создан как некоммерческий с целью информирования и распространения информации о рынке криптовалют. Данный проект поддерживается Петровым Алексеем (<a href="http://www.avpetrov.ru">www.avpetrov.ru</a>). Если вы хотите предложить сотрудничество или поддержать проект напишите мне в <a href="https://t.me/AlekseyPV">телеграмм</a> <!-- (<a href="">https://t.me/AlekseyPV</a>) --> заранее,спасибо.</p>
    				</div>
    			</div>
    		</div>

    		<!-- <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="height: 170px; width: 170px;" colspan="1" rowspan="3"><img style="width: 167px; height: 167px;" alt="" src="img/photo_2018-02-08_15-37-41.jpg"></td>
      <td><font color="white">Эксперт</font></td>
    </tr>
    <tr>
      <td><font color="white">Текст</font></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </tbody>
</table> -->

    	</div>
    </section>





    <script src="js/main.scroll.js"></script>
	<script src="js/jquery.scroller.js"></script>
	<script src="js/demo.js"></script>
  <script src="js/dynamicTable.js"></script>
<script>
    new DynamicTable( document.getElementById("dynamic") );
</script>
  </body>
</html>

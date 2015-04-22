<?php  if ( ! defined('INVIS_BASEDIR')) exit('No direct script access allowed');

/*****************************************************/
/***   _____             _                    ___  ***/ 
/***   \_   \_ ____   __(_)___    /\/\/\   /\/ __\ ***/ 
/***    / /\/ '_ \ \ / /| / __|  /    \ \ / / /    ***/ 
/*** /\/ /_ | | | \ V / | \__ \ / /\/\ \ V / /___  ***/ 
/*** \____/ |_| |_|\_/  |_|___/ \/    \/\_/\____/  ***/  
/***                                               ***/
/*****************************************************/
/***                                               ***/
/*** Name      :  Invis MVC                        ***/
/*** Copyright :  (c) 2011, Invis MVC Team         ***/
/*** License   :  http://www.invismvc.com/license  ***/
/*** Contact   :  mail@invismvc.com                ***/
/***                                               ***/
/*** File      :  system/iinput.php                ***/
/*** Version   :  1.0                              ***/
/***                                               ***/
/*****************************************************/
/*****************************************************/




/*****************************************************/
/***                 BBCODE CLASS                  ***/
/*****************************************************/
/*
class bBcode
{

	function bb2html($text){
		$bbcode = array("<", ">",
                "[list]", "[*]", "[/list]",
                "[img]", "[/img]",
                "[b]", "[/b]",
                "[u]", "[/u]",
                "[i]", "[/i]",
                "[color=", "[/color]",
                "[size=", "[/size]",
                "[url=", "[/url]",
                "[mail=", "[/mail]",
                "[code]", "[/code]",
                "[quote]", "[/quote]",
				"[cool]", "[/cool]", //13
				"[indent]", "[/indent]",
				"[lyrics]", "[/lyrics]",//15
				"[table]","[/table]",
				"[tr]","[/tr]",
				"[td]","[/td]",
				"[smallcaps]", "[/smallcaps]",
				"[big]", "[/big]",
				"[small]", "[/small]",
				"[tt]", "[/tt]",
				"[sub]", "[/sub]",
				"[sup]", "[/sup]",
				"[copyright /]",
				"[registered /]",
				"[tm /]",
				"[bull /]",
				"[s]","[/s]",
				"[youtube]","[/youtube]",
				"]",
                "']");
		$htmlcode = array("&lt;", "&gt;",
                "<ul>", "<li>", "</ul>",
                "<img src='", "'>",
                "<b>", "</b>",
                "<u>", "</u>",
                "<i>", "</i>",
                "<font color=", "</font>",
                "<font size=", "</font>",
                "<a href=", "</a>",
                "<a href=mailto:", "</a>",
                "<div style='width: 80%; overflow: auto; text-align: left; border: 1px solid #CCCCCC; display: block; padding-left: 20px;'><code style='white-space: pre;'>", "</div>",
                "<table width=100% bgcolor=lightgray><tr><td bgcolor=white>", "</td></tr></table>",
				"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; letter-spacing: 2px; word-spacing: 3px; font-size: 13px; font-weight: bold; font-style: italic; color: #333399; font-variant: small-caps; height: 12px; padding-left: 9pt; padding-right: 6pt; vertical-align: middle; display: block;'>", "</span>",  //13
				"<div style='width: 80%; overflow: auto; text-align: left; border: 1px solid #CCCCCC; display: block; padding-left: 20px;'><code style='white-space: pre;'>", "[/code]",
				"<span style='margin-left: 30px; font-style: italic; display: block;'>", "</span>",//15
				"<table>","</table>",
				"<tr>","</tr>",
				"<td>","</td>",
				"<span style='font-variant: small-caps;'>", "</span>",
				"<span style='font-size: 22px;'>", "</span>",
				"<span style='font-size: 10px;'>", "</span>",
				"<tt>", "</tt>",
				"<sub>", "</sub>",
				"<sup>", "</sup>",
				"&copy;",
				"&reg;",
				"<big>&trade;</big>",
				"<big>&bull;</big>",
				"<del>","</del>",
				"<object width='425' height='350'><embed src='http://www.youtube.com/v/","' type='application/x-shockwave-flash' width='425' height='350'></embed></object>",
				">",
                "'>");
		$newtext = str_replace($bbcode, $htmlcode, $text);
		$newtext = nl2br($newtext);//second pass
		return $newtext;
	}
}
*/
class bBcode {

  private static $simple_search = array(
    '/\[b\](.*?)\[\/b\]/is',
    '/\[i\](.*?)\[\/i\]/is',
    '/\[u\](.*?)\[\/u\]/is',
    '/\[s\](.*?)\[\/s\]/is',
    '/\[size\=(.*?)\](.*?)\[\/size\]/is',
    '/\[color\=(.*?)\](.*?)\[\/color\]/is',
    '/\[center\](.*?)\[\/center\]/is',
    '/\[font\=(.*?)\](.*?)\[\/font\]/is',
    '/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
    
    '/\[url\](.*?)\[\/url\]/is',
    '/\[url\=(.*?)\](.*?)\[\/url\]/is',
    '/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
    '/\[mail\](.*?)\[\/mail\]/is',
    '/\[img\](.*?)\[\/img\]/is',
    '/\[img\=(\d*?)x(\d*?)\](.*?)\[\/img\]/is',
    '/\[img (.*?)\](.*?)\[\/img\]/ise',

    '/\[quote\](.*?)\[\/quote\]/is',
    '/\[quote\=(.*?)\](.*?)\[\/quote\]/is',
    '/\[code\](.*?)\[\/code\]/is',
    
    '/\[sub\](.*?)\[\/sub\]/is',
    '/\[sup\](.*?)\[\/sup\]/is',
    '/\[p\](.*?)\[\/p\]/is',
    
    "/\[youtube\](.*?)\[\/youtube\]/i",
    "/\[gvideo\](.*?)\[\/gvideo\]/i",
	"/\[table\](.*?)\[\/table\]/is",
	"/\[tr\](.*?)\[\/tr\]/is",
	"/\[\td](.*?)\[\/td\]/is",
	"/\[\th](.*?)\[\/th\]/is",
    
    // "Specials", XHTML-like BBC Repository
    '/\[bull \/\]/i',
        '/\[copyright \/\]/i',
        '/\[registered \/\]/i',
        '/\[tm \/\]/i',
  );
  
  private static $simple_replace = array(
    '<strong>$1</strong>',
    '<em>$1</em>',
    '<u>$1</u>',          // you can also use: '<span style="text-decoration: underline;">$1</span>'
    '<del>$1</del>',      // you can also use: '<span style="text-decoration: line-through;">$1</span>'
    '<font size="$1">$2</font>',
    '<font color=" $1">$2</font>',
    '<div style="text-align: center;">$1</div>',
    '<span style="font-family: $1;">$2</span>',
    '<div style="text-align: $1;">$2</div>',
    
    '<a href="$1">$1</a>',
    '<a href="$1">$2</a>',
    '<a href="mailto:$1">$2</a>',
    '<a href="mailto:$1">$1</a>',
    '<img src="$1" alt="" />',
    '<img height="$2" width="$1" alt="" src="$3" />',
    '"<img " . str_replace("&#039;", "\"",str_replace("&quot;", "\"", "$1")) . " src=\"$2\" />"',   // we replace &quot; and &#039; to " in case if we got string converted to html entities

    '<blockquote>$1</blockquote>',                              // you can also use: '<div class="quote">$1</div>'
    '<blockquote><strong>$1 wrote:</strong> $2</blockquote>',   // you can also use: '<div class="quote"><strong>$1 wrote:</strong> $2</div>
    '<pre>$1</pre>',
    
    '<sub>$1</sub>',
    '<sup>$1</sup>',
    '<p>$1</p>',
    
    "<object width=\"425\" height=\"350\"><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" width=\"425\" height=\"350\"></embed></object>",
    "<embed src=\"http://video.google.com/googleplayer.swf?docId=$1\" type=\"application/x-shockwave-flash\" style=\"width: 425px; height: 350px;\">",
    "<table>$1</table>",
	"<tr>$1</tr>",
	"<td>$1</td>",
	"<th>$1</th>",
    // "Specials", XHTML-like BBC Repository
    '&bull;',
        '&copy;',
        '&reg;',
        '&trade;',
  );
  
  private static $lineBreaks_search = array(
      // [list]
      '/\<br \/\>\s*\[list(.*?)\]/i',     // uncomment to remove <br /> before the tag
      '/\[list(.*?)\](.+?)\[\/list\]/sie',
      '/\[\/list\]\s*\<br \/\>/i',
      
      // [code]
      '/\<br \/\>\s*\[code\]/i',          // uncomment to remove <br /> before the tag
      '/\[code\](.+?)\[\/code\]/sie',
      '/\[\/code\]\s*\<br \/\>/i',
      
      // [quote]
      '/\<br \/\>\s*\[quote(.*?)\]/i',    // uncomment to remove <br /> before the tag
      '/\[\/quote\]\s*\<br \/\>/i',
      
      // [p]
      '/\<br \/\>\s*\[p\]/i',             // uncomment to remove <br /> before the tag
      '/\[\/p\]\s*\<br \/\>/i',
      
      // [center]
      '/\<br \/\>\s*\[center\]/i',        // uncomment to remove <br /> before the tag
      '/\[\/center\]\s*\<br \/\>/i',
      
      // [align]
      '/\<br \/\>\s*\[align(.*?)\]/i',    // uncomment to remove <br /> before the tag
      '/\[\/align\]\s*\<br \/\>/i',
    );
    
    private static $lineBreaks_replace = array(
      // [list]
      "\n[list$1]",         // uncomment to remove <br /> before the tag
      "'[list$1]'.str_replace('<br />', '', '$2').'[/list]'",
      "[/list]",
      
      // [code]
      "\n[code]",           // uncomment to remove <br /> before the tag
      "'[code]'.str_replace('<br />', '', '$1').'[/code]'",
      "[/code]",
      
      // [quote]
      "\n[quote$1]",        // uncomment to remove <br /> before the tag
      "[/quote]",
      
      // [p]
      "\n[p]",              // uncomment to remove <br /> before the tag
      "[/p]",
      
      // [center]
      "\n[center]",         // uncomment to remove <br /> before the tag
      "[/center]",
      
      // [align]
      "\n[align$1]",        // uncomment to remove <br /> before the tag
      "[/align]",
    );

  private static function process_list_items($list_items) {
    $result_list_items = array();
    
    // Check for [li][/li] tags
    preg_match_all("/\[li\](.*?)\[\/li\]/is", $list_items, $li_array);
    $li_array = $li_array[1];
    
    if (empty($li_array)) {
        // we didn't find any [li] tags
        $list_items_array = explode("[*]", $list_items);
        foreach ($list_items_array as $li_text) {
            $li_text = trim($li_text);
            if (empty($li_text)) {
                continue;
            }
            $li_text = nl2br($li_text);
            $result_list_items[] = '<li>'.$li_text.'</li>';
        }
    } else {
        // we found [li] tags!
        foreach ($li_array as $li_text) {
            $li_text = nl2br($li_text);
            $result_list_items[] = '<li>'.$li_text.'</li>';
        }
    }
    
    $list_items = implode("\n", $result_list_items);
    
    return $list_items;
  }
  
  /*
  ARGUMENTS :
  $string = the text you want to format
  */
  
  public static function parse($string) {
    
	$string=htmlentities($string,ENT_COMPAT, "UTF-8");
    $s = (string) $string;
    //return $s;
    if (empty($s)) {
      return '';
    }
    
    // Preappend http:// to url address if not present
    $s = preg_replace('/\[url\=([^(http)].+?)\](.*?)\[\/url\]/i', '[url=http://$1]$2[/url]', $s);
    $s = preg_replace('/\[url\]([^(http)].+?)\[\/url\]/i', '[url=http://$1]$1[/url]', $s);
    
    // Add line breaks
    $s = nl2br($s);
    
    // Remove the trash made by previous 
    $s = preg_replace(self::$lineBreaks_search, self::$lineBreaks_replace, $s);
    
    // Parse bbcode
    $s = preg_replace(self::$simple_search, self::$simple_replace, $s);

    // Parse [list] tags
    $s = preg_replace('/\[list\](.*?)\[\/list\]/sie', '"<ul>\n".self::process_list_items("$1")."\n</ul>"', $s);
    $s = preg_replace('/\[list\=(disc|circle|square|decimal|decimal-leading-zero|lower-roman|upper-roman|lower-greek|lower-alpha|lower-latin|upper-alpha|upper-latin|hebrew|armenian|georgian|cjk-ideographic|hiragana|katakana|hiragana-iroha|katakana-iroha|none)\](.*?)\[\/list\]/sie',
                '"<ol style=\"list-style-type: $1;\">\n".self::process_list_items("$2")."\n</ol>"', $s);
    
    return $s;
  }

}

?>
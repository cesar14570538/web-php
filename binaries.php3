<?
require("shared.inc");

$apache_version="1.3.0";
$php_version="3.0";

function makeCap() {
	GLOBAL $MIRRORS, $COUNTRIES,$PHP_SELF,$MYSITE;
	global $showcountry,$showsites,$csel;
?>
<TR bgcolor='#D0D0D0' valign=top>
<TD ALIGN=left><IMG ALT=" " SRC="/gifs/gcap-lefttop.gif" WIDTH=18 HEIGHT=18 BORDER=0><BR></TD>
<TD align=center colspan=3 rowspan=2 NOWRAP>
<?
if (!isset($csel)) {
	$csel='';
	if (!($hostname=getenv("REMOTE_HOST"))) {
		$ipaddr=getenv("REMOTE_ADDR");
		$hostname=gethostbyaddr($ipaddr);
		if ($hostname==$ipaddr) { $hostname=""; }
	}
	if ($hostname) {
		if (ereg('([a-zA-Z]+)$',$hostname,$reg)) {
			$csel=$reg[0];
		}
	}
}
if ($COUNTRIES[$csel]) {
	$showcountry=$csel;
} else {
	$info=$MIRRORS[$MYSITE];
	$showcountry=$info[0];
	if (!$showcountry) {
		$showcountry="us";
	}
}
$mirror_sites=$MIRRORS;
$count=0;
$lastc="";
reset($mirror_sites);
while ($site = key($mirror_sites)) {
	$info = $mirror_sites[$site];
	next($mirror_sites);
	$c = $info[0];
        $cname=$COUNTRIES[$c];
	if ($c==$showcountry) {
		$showsites[]=$site;
	}
	if ($c == $lastc || $c == 'xx') {
		continue;
	}
	$count++;
	echo "<A HREF=\"$PHP_SELF?csel=$c\"><IMG SRC=\"/gifs/gflag-$c.gif\" WIDTH=45 HEIGHT=24 VSPACE=5 hspace=15 BORDER=0 ALT=\"$cname\"></A>";
	if ($count%5==0) {
		echo "<BR>\n";
	}
	$lastc = $c;
}
?><BR>
</TD>
<TD ALIGN=right><IMG ALT=" " SRC="/gifs/gcap-righttop.gif" WIDTH=18 HEIGHT=18 BORDER=0><BR></TD>
</TR>
<TR VALIGN=bottom bgcolor='#D0D0D0'>
<TD ALIGN=left><IMG alt=" " SRC="/gifs/gcap-leftbot.gif" WIDTH=18 HEIGHT=18 BORDER=0><BR></TD>
<TD ALIGN=right><IMG alt=" " SRC="/gifs/gcap-rightbot.gif" WIDTH=18 HEIGHT=18 BORDER=0><BR></TD>
</TR>
<?
};


commonHeader("Download PHP Apache+PHP Binary Tarballs for UNIX");
?>
<FONT SIZE=+1><B>Choose a country to download from:</B></FONT><BR>
<I>(the closest has automagically been selected for you)</I><BR>
<BR>
The binary distributions on this page are experimental, unsupported and most
likely outdated.  Building from the source tarball is strongly suggested.
<BR><BR>

<CENTER>
<TABLE border=0 cellpadding=0 cellspacing=0>
<?
makeCap();

$thisurl=substr($PHP_SELF,1); /* strip leading slash */
$mirror_sites=$MIRRORS;
$lastcountry="xxxxx";
reset($showsites);
while ($site = current($showsites)) {
	next($showsites);
	$info = $mirror_sites[$site];
	list($country, $location, $shortname, $companyurl, $show) = $info;
	$cname=$COUNTRIES[$country];
	if (!$show) {
		continue;
	}
	if (eregi("^http://",$site)) {
		$method="HTTP";
		$srcdir="distributions/";
	} elseif (eregi("^ftp://",$site)) {
		$method="FTP";
		$srcdir="";
	} else {
		$method="unknown";
	}
	if ($lastcountry!=$country) {
		echo "<TR><TD colspan=3><BR></TD><TD BGCOLOR='#F0F0F0'><BR></TD><TD><BR></TD></TR>\n";
		echo "<TR BGCOLOR='#D0D0D0' VALIGN=middle>\n";
		echo "<TD><IMG SRC='/gifs/gcap-left.gif' WIDTH=18 HEIGHT=36 BORDER=0 ALT=' '></TD>\n";
		echo "<TD><A HREF=\"$site$thisurl?csel=$country\"><IMG SRC='/gifs/gflag-$country.gif' ALT='$cname' WIDTH=45 HEIGHT=24 vspace=6 BORDER=0 hspace=10></A><BR></TD>\n";
		echo "<TD colspan=2>";
		echo "<FONT FACE='$FONTFACE'><B>$COUNTRIES[$country]</B><BR></TD>\n";
		echo "<TD align=right><IMG ALT=' ' SRC='/gifs/gcap-right.gif' WIDTH=18 HEIGHT=36 BORDER=0><BR></TD>\n";
		echo "</TR>\n";
		$lastcountry=$country;
	}
	echo "<TR><TD colspan=3>";
	spc(75,1);
	echo "<BR></TD>\n<TD>";
	echo "<TABLE border=0 cellpadding=5 cellspacing=0 bgcolor=\"#F0F0F0\" width=100%>\n";
	echo "<TR><TD><FONT FACE='$FONTFACE'>\n";
	if ((!isset($lastlocation))||($lastlocation!=$location)) {
		echo("$location<BR>\n");
		$lastlocation=$location;
	}
	echo "<FONT SIZE=-1><UL>\n";
	$rpm_i386_file = "${site}${srcdir}mod_php3-3.0.5-1.i386.rpm";
	$rpm_src_file = "${site}${srcdir}mod_php3-3.0.5-1.src.rpm";
	$amiga_file = "${site}${srcdir}Apache-1.3.3-PHP-3.0.6.lha";
	echo "<LI>";
	download_link($rpm_i386_file, "($method) i386 RPM, dynamically loadable Apache 1.3 module");
	echo "\n";
	echo "<LI>";
	download_link($rpm_src_file, "($method) Source RPM, dynamically loadable Apache 1.3 module");
	echo "\n";
	echo "<LI>";
	download_link($amiga_file, "($method) Amiga Apache-1.3.3 w/ PHP-3.0.6 + XML,GD,PDF,mSQL,MySQL");
	echo "\n";
	echo("</UL>\n</TD></TR></TABLE></TD></TR>\n");
}
?>

<TR><TD colspan=3><BR></TD><TD BGCOLOR='#F0F0F0'><BR></TD><TD><BR></TD></TR>
<TR BGCOLOR='#D0D0D0' VALIGN=middle>
<TD><IMG SRC='/gifs/gcap-left.gif' WIDTH=18 HEIGHT=36 BORDER=0 ALT=' '></TD>
<TD COLSPAN=4 align=right><IMG ALT=' ' SRC='/gifs/gcap-right.gif' WIDTH=18 HEIGHT=36 BORDER=0><BR></TD>
</TR>


</TABLE>
<?
commonFooter();
?>

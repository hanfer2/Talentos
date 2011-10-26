<?php
function	q($text)	{
	if(!is_string($text))
		return $text;
	return	pg_escape_string($text);
}

function	db_format($in)	{
	$in	=	utf8_decode(q($in));
	if	(is_blank($in))
		return	'NULL';
	else	if	(preg_match("/(^\'.*\'$)/",	$in))
		return	$in;
	else if(is_bool($in))
		return ($in) ? "TRUE": "FALSE";
	else
		return	"'$in'";
}

function	sql_insert_from_array($table,	$data)	{
	$keys	=	array_keys($data);
	$keys_number	=	count($keys);

	$column_names	=	"";
	$values	=	"";

	for	($i	=	0;	$i	<	$keys_number;	$i++)	:
		$column_names	.=	"\"$keys[$i]\"";
		$values	.=	db_format($data[$keys[$i]]);

		// We don't add "," after the last one
		if	($i	!=	($keys_number	-	1)):
			$column_names	.=	", ";
			$values	.=	", ";
		endif;

	endfor;

	$sql	=	"INSERT INTO $table ($column_names) VALUES ($values)";

	return	$sql;
}

function	sql_update_from_array($table,	$data,	$condition)	{

	$updates	=	array();
	foreach	($data	as	$key	=>	$value):
		$updates[]	=	"$key ="	.	db_format($value);
	endforeach;
	$updates	=	join(', ',	$updates);

	$sql	=	"UPDATE $table SET $updates";

	if	(!is_blank($condition))
		$sql	.=	" WHERE $condition";

	return	$sql;
}

function sql_rangeize($params){
	if(is_blank($params))
		return "";
	if(!is_array($params))
		return $params;
	$sql = array();
	foreach($params as $param)
		$sql[] = "'$param'";
	return join(", ", $sql);
}

?>

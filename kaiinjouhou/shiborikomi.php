<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>絞り込み</title>
</head>
<body>
  <button onclick="location.href='rireki.php'">戻る</button>

	<form action="rireki.php" method="post">

		<table>
			<tbody>
				<tr>
					<td rowspan="3">購入時期</td>
					<td colspan="2"><label for="l30d"><input type="radio" id="l30d" name="kounyu" value="last_30_days">過去30日</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="l6m"><input type="radio" id="l6m" name="kounyu" value="last_6_months">過去6ヶ月</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="py"><input type="radio" id="py" name="kounyu" value="past_year">過去1年</label></td>
				</tr>
			</tbody>
		</table>

		<table>
			<tbody>
				<tr>
					<td rowspan="5">商品種別</td>
					<td colspan="2"><label for="syouhin1"><input type="radio" id="syouhin1" name="syubetu" value="kagu">家具</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="syouhin2"><input type="radio" id="syouhin2" name="syubetu" value="syokuzai">食材</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="syouhin3"><input type="radio" id="syouhin3" name="syubetu" value="gangu">玩具</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="syouhin4"><input type="radio" id="syouhin4" name="syubetu" value="nitiyouhin">日用品</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="syouhin5"><input type="radio" id="syouhin5" name="syubetu" value="kaden">家電</label></td>
				</tr>
			</tbody>
		</table>

		<table>
			<tbody>
				<tr>
					<td rowspan="5">値段</td>
					<td colspan="2"><label for="nedan1"><input type="radio" id="nedan1" name="nedan" value="1">～1000円</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="nedan2"><input type="radio" id="nedan2" name="nedan" value="2">1001円～5000円</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="nedan3"><input type="radio" id="nedan3" name="nedan" value="3">5001円～10000円</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="nedan4"><input type="radio" id="nedan4" name="nedan" value="4">10001円～50000円</label></td>
				</tr>
				<tr>
					<td colspan="2"><label for="nedan5"><input type="radio" id="nedan5" name="nedan" value="5">50001円～</label></td>
				</tr>
			</tbody>
		</table>

		<button type="submit" name="siborikomi">適用する</button>

	</form>

</body>
</html>

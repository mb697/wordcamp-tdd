<p class="description">
	I lacked the imagination to come up with a reason why anyone would want to store a month and year combo, but lets just agree that they do, so we are going to do it.
</p>

<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Month / Year</th>
			<td>
                <select name="month_year">

                <?php foreach ( $month_years as $month_year ) : ?>

                    <option><?php echo $month_year; ?></option>

                <?php endforeach; ?>

                </select>
            </td>
		</tr>
	</tbody>
</table>

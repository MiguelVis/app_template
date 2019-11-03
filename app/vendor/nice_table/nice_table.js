function NiceTableSetPage(id, num) {
	document.getElementById(id + "_page").value = num;
	document.getElementById(id + "_form").submit();
}

function NiceTableSetPageLength(id, num) {
	document.getElementById(id + "_page_length").value = num;
	
	NiceTableSetPage(id, 0);
}

function NiceTableSort(id, field, order) {
	document.getElementById(id + "_sort_by").value = field;
	document.getElementById(id + "_sort_order").value = order;
	
	NiceTableSetPage(id, 0);
}

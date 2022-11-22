$(document).ready(() => {
	const listTable = [
		"#table-admin-induk",
		"#table-daftar-unit",
		"#table-menu",
		"#table-sub-menu",
		"#table-access",
		"#table-role",
		"#table-artikel",
		"#table-kategori",
		"#table-jenis-sampah",
		// "#table-balance",
		"#table-upload",
		"#table-jadwal",
		// "#table-request",
		"#table-pengeluaran",
		"#table-pemasukan",
		"#table-mutasi",
		"#table-pelapak",
	];
	// $("#table-admin-induk").DataTable();\
	listTable.forEach((table) => {
		makeTable(table);
	});
});

$("#table-balance").dataTable({
	"bAutoWidth": false ,
	aoColumns: [
		null,
		null,
		null,
		{ "sWidth": "10%" },
		null,
		null,
		null,
		null,
		null,
		null,
		{ "sWidth": "18%" },
	],
});

$("#table-request").dataTable({
	columns: [
		null,
		{ width: "10%" },
		null,
		{ width: "10%" },
		null,
		null,
		{ width: "13%" },
		{ width: "15%" },
		{ width: "10%" },
		{ width: "20%" },
	],
});

$("#table-jadwal-sampah").DataTable({
	lengthMenu: [5, 10, 20, 50],
	searching: false,
});

const makeTable = (id) => {
	$(id).DataTable({
		lengthMenu: [5, 10, 20, 50],
	});
};
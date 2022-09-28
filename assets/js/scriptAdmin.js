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
		"#table-balance",
		"#table-upload",
		"#table-jadwal",
		"#table-request",
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

const makeTable = (id) => {
	$(id).DataTable({
		lengthMenu: [5, 10, 20, 50],
	});
};
$("#table-jadwal-sampah").DataTable({
	lengthMenu: [5, 10, 20, 50],
	searching: false,
});
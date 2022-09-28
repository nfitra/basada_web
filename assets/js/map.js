const map = L.map("map").setView([0.4980692121501651, 101.44024372100831], 12);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
	attribution:
		'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	tileSize: 512,
	zoomOffset: -1,
}).addTo(map);

const allPath = window.location.pathname.split('/');
const path = allPath[allPath.length-1];
const base_url = window.location.href.replace(path,"")

fetch(`${base_url}get_map`)
	.then(res=>res.json())
	.then(result=>{
		result.map(el => {
			if(el.un_location && el.un_status === "Aktif"){
				let text = `<div style="padding: 10px; border: 1px solid black;">
					Nama: ${el.un_name}<br/>
					Alamat: ${el.un_address}<br/>
					Kontak: ${el.un_contact ? el.un_contact: "Tidak ada"}
				</div>`
				const coord = el.un_location.split(',');
				L.marker([coord[0],coord[1]])
					.addTo(map)
					.bindPopup(text)
			}
		});
	});

// L.marker([0.570012, 101.425655])
// 	.addTo(map)
// 	.bindPopup("This is at 0.570012, 101.425655")
// 	.openPopup();

// map.addEventListener("click", (e) => {
// 	console.log(e.latlng);
// });

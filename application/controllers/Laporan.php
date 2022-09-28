<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library("Excel");
        $this->load->library("Pdf");
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Unit_model');
        $this->load->model('Auth_model');
        $this->load->model('KategoriSampah_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Pemasukan_model');
        $this->load->model('Pengeluaran_model');
        $this->load->model('Transaksi_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Laporan Transaksi Sampah',
            'active' => 'Laporan Sampah',
            'user' => _get_user($this),
            'listKategori' => $this->KategoriSampah_model->get_kategori()
        );

        $config = [
            [
                'field' => 'date',
                'label' => 'Waktu',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'date2',
                'label' => 'Waktu 2',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'laporan',
                'label' => 'Laporan',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'jenis',
                'label' => 'Jenis File',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "transaksi/laporan", $data);
        } else {
            $status = xss_input($this->input->post('status', true));
            $date = xss_input($this->input->post('date', true));
            $date2 = xss_input($this->input->post('date2', true));
            $tgl = explode("-", $date);
            $month = date("F", mktime(0, 0, 0, $tgl[1], 10));
            $tgl2 = explode("-", $date2);
            $month2 = date("F", mktime(0, 0, 0, $tgl2[1], 10));
            $laporan = xss_input($this->input->post('laporan', true));
            $namaLaporan = "Laporan $laporan ";
            if ($status != "Semua" && $laporan == "Nasabah") {
                $namaLaporan .= "$status";
            }
            $namaLaporan .= " Periode " . $tgl[2] . " " . $month . " " . $tgl[0] . " - " . $tgl2[2] . " " . $month2 . " " . $tgl2[0];
            $jenis = xss_input($this->input->post('jenis', true));
            if ($date > $date2) {
                $temp = $date;
                $date = $date2;
                $date2 = $temp;
            }

            if ($jenis == "excel")  $this->downloadExcel($laporan, $date, $date2, $namaLaporan);
            else                    $this->downloadPDF($laporan, $date, $date2, $namaLaporan);
        }
    }

    function downloadExcel($laporan, $date = "", $date2 = "", $judul)
    {
        $status = xss_input($this->input->post('status', true));
        if ($laporan == "Nasabah") {
            $table = [
                ["alphabet" => "A", "column" => "No"],
                ["alphabet" => "B", "column" => "Nama Nasabah"],
                ["alphabet" => "C", "column" => "Tanggal Lahir"],
                ["alphabet" => "D", "column" => "Alamat"],
                ["alphabet" => "E", "column" => "Kota"],
                ["alphabet" => "F", "column" => "Provinsi"],
                ["alphabet" => "G", "column" => "Kode Pos"],
                ["alphabet" => "H", "column" => "Kontak"],
                ["alphabet" => "I", "column" => "Saldo"],
                ["alphabet" => "J", "column" => "Waktu"],
            ];
            $listLaporan = $this->Nasabah_model->get_data($date, $date2, $status);
        } else if ($laporan == "Pemasukan") {
            $table = [
                ["alphabet" => "A", "column" => "No"],
                ["alphabet" => "B", "column" => "Jenis Sampah"],
                ["alphabet" => "C", "column" => "Keterangan"],
                ["alphabet" => "D", "column" => "Jumlah"],
                ["alphabet" => "E", "column" => "Total Harga"],
                ["alphabet" => "F", "column" => "Waktu"],
            ];
            $listLaporan = $this->Pemasukan_model->get_data($date, $date2);
        } else if ($laporan == "Pengeluaran") {
            $table = [
                ["alphabet" => "A", "column" => "No"],
                ["alphabet" => "B", "column" => "Bulan"],
                ["alphabet" => "C", "column" => "Jenis Pengeluaran"],
                ["alphabet" => "D", "column" => "Jumlah"],
                ["alphabet" => "E", "column" => "Harga Satuan"],
                ["alphabet" => "F", "column" => "Total Harga"],
                ["alphabet" => "G", "column" => "Bank Unit"],
                ["alphabet" => "H", "column" => "Keterangan"],
            ];
            $listLaporan = $this->Pengeluaran_model->get_data($date, $date2);
        } else if ($laporan == "Transaksi") {
            $table = [
                ["alphabet" => "A", "column" => "No"],
                ["alphabet" => "B", "column" => "Nama Sampah"],
                ["alphabet" => "C", "column" => "Total Berat"],
                ["alphabet" => "D", "column" => "Satuan"],
                ["alphabet" => "E", "column" => "Total Harga"],
            ];
            $listLaporan = $this->Transaksi_model->get_data_transaksi_kategori($date, $date2, $status);
        }
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('BASADA')
            ->setTitle("Laporan Transaksi Sampah")
            ->setSubject("Transaksi")
            ->setDescription("Laporan Transaksi Sampah");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        // $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        // $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->getActiveSheet()->mergeCells("A1:Z1");
        $excel->setActiveSheetIndex(0)->setCellValue('A1', $judul);
        $excel->getActiveSheet()->getStyle('A1')->applyFromArray(["font" => ["size" => 22]]);

        $numrow = 3;

        if ($listLaporan) {
            if ($laporan == "Transaksi") {
                $prevnum = 3;
                foreach ($listLaporan as $laporan) {
                    $excel->getActiveSheet()->mergeCells("A" . $numrow . ":" . "E" . $numrow);
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $laporan->k_name);
                    $excel->getActiveSheet()->getStyle("A" . $numrow . ":" . "E" . $numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()->getStyle("A" . $numrow . ":" . "E" . $numrow)->applyFromArray($style_col);
                    $numrow++;

                    foreach ($table as $value) {
                        $excel->setActiveSheetIndex(0)->setCellValue($value["alphabet"] . $numrow, $value["column"]);
                        $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_col);
                    }
                    $numrow++;
                    $prevnum = $numrow;

                    $transaksi = $this->Transaksi_model->get_data_transaksi(["fk_kategori" => $laporan->_id], $date, $date2, $status);
                    
                    $no = 1;
                    $total = 0;
                    foreach ($transaksi as $data) { // Lakukan looping pada variabel siswa
                        $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->j_name);
                        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->berat_total);
                        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->satuan);
                        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->harga_total);
                        $total += $data->harga_total;
                        foreach ($table as $value) {
                            $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_row);
                        }
                        $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0.00_);_(\"Rp\"* \(#,##0.00\);_(\"Rp\"* \"-\"??_);_(@_)");
                        $no++;
                        $numrow++;
                    }
                    $excel->getActiveSheet()->mergeCells("A" . $numrow . ":" . "D" . $numrow);
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "Total");
                    $excel->getActiveSheet()->getStyle("A" . $numrow . ":" . "E" . $numrow)->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle("A" . $numrow . ":" . "E" . $numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, "=SUM(E".$prevnum.":E".($numrow - 1).")");
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $total);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0.00_);_(\"Rp\"* \(#,##0.00\);_(\"Rp\"* \"-\"??_);_(@_)");
                    $numrow += 2;
                }
            } else if ($laporan == "Nasabah") {
                foreach ($table as $value) {
                    $excel->setActiveSheetIndex(0)->setCellValue($value["alphabet"] . $numrow, $value["column"]);
                    $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_col);
                }
                $numrow++;
                $no = 1;
                foreach ($listLaporan as $data) { // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->n_name);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->n_dob);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->n_address);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->n_city);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->n_province);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->n_postcode);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->n_contact);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->n_balance);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->n_created_at);
                    foreach ($table as $value) {
                        $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_row);
                    }
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0.00_);_(\"Rp\"* \(#,##0.00\);_(\"Rp\"* \"-\"??_);_(@_)");
                    $no++;
                    $numrow++;
                }
            } else if ($laporan == "Pemasukan") {
                foreach ($table as $value) {
                    $excel->setActiveSheetIndex(0)->setCellValue($value["alphabet"] . $numrow, $value["column"]);
                    $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_col);
                }
                $numrow++;
                $no = 1;
                // echo "<pre>";
                // print_r($listLaporan);
                // echo "</pre>";
                foreach ($listLaporan as $data) { // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->j_name ? $data->j_name : "-");
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->pm_hasil);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->pm_jumlah);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->pm_total);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->pm_created_at);
                    foreach ($table as $value) {
                        $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_row);
                    }
                    $no++;
                    $numrow++;
                }
            } else if ($laporan == "Pengeluaran") {
                foreach ($table as $value) {
                    $excel->setActiveSheetIndex(0)->setCellValue($value["alphabet"] . $numrow, $value["column"]);
                    $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_col);
                }
                $numrow++;
                $no = 1;
                foreach ($listLaporan as $data) { // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->pk_bulan);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->pk_jenis);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->pk_jumlah);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->pk_harga);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->pk_total);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->un_name ? $data->un_name : "-");
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->pk_keterangan ? $data->pk_keterangan : "-");
                    foreach ($table as $value) {
                        $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_row);
                    }
                    $no++;
                    $numrow++;
                }
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "Tidak Ada Data $laporan");
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray(["font" => ["size" => 22]]);
        }


        foreach ($table as $value) {
            $excel->getActiveSheet()->getColumnDimension($value['alphabet'])->setAutoSize(true);
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan BASADA");
        $excel->setActiveSheetIndex(0);
        
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . "Laporan BASADA.xlsx"); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    function downloadPDF($laporan, $date = "", $date2 = "", $judul)
    {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Laporan ' . $judul);
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->setPrintHeader(false);
        $pdf->SetAuthor('BASADA');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();

        if ($laporan == "Nasabah") {
            $status = xss_input($this->input->post('status', true));
            $table = ["No", "Nama Nasabah", "Tanggal Lahir", "Alamat", "Kota", "Provinsi", "Kode Pos", "Kontak", "Saldo", "Waktu"];
            $listLaporan = $this->Nasabah_model->get_data($date, $date2, $status);
        } else if ($laporan == "Pemasukan") {
            $table = ["No", "Jenis Sampah", "Keterangan", "Jumlah", "Total Harga", "Waktu"];
            $listLaporan = $this->Pemasukan_model->get_data($date, $date2);
        } else if ($laporan == "Pengeluaran") {
            $table = ["No", "Bulan", "Jenis Pengeluaran", "Jumlah", "Harga Satuan", "Total Harga", "Bank Unit", "Keterangan"];
            $listLaporan = $this->Pengeluaran_model->get_data($date, $date2);
        } else if ($laporan == "Transaksi") {
            $status = xss_input($this->input->post('kategori', true));
            $table = ["No", "Nama Sampah", "Total Berat", "Satuan", "Total Harga"];
            $listLaporan = $this->Transaksi_model->get_data_transaksi_kategori($date, $date2, $status);
        }

        $html = "<h3>$judul</h3>";

        if ($listLaporan) {
            if ($laporan == "Transaksi") {
                foreach ($listLaporan as $laporan) {
                    $transaksi = $this->Transaksi_model->get_data_transaksi(["fk_kategori" => $laporan->_id], $date, $date2, $status);
                    $html .= '<table cellpadding="5" border="0.5">';
                    $html .= '<tr>
                                <th colspan="5" align="center"><b>' . $laporan->k_name . '</b></th>
                            </tr>
                            <tr>
                                <th width="10%" align="center"><b>No</b></th>
                                <th width="45%" align="center"><b>Nama Sampah</b></th>
                                <th width="15%" align="center"><b>Total Berat</b></th>
                                <th width="10%" align="center"><b>Satuan</b></th>
                                <th width="20%" align="center"><b>Total Harga</b></th>
                            </tr>';
                    $no = 1;
                    $total = 0;
                    foreach ($transaksi as $data) {
                        $html .= '<tr>
                                    <td align="center">' . $no++ . '</td>
                                    <td>' . $data->j_name . '</td>
                                    <td>' . $data->berat_total . '</td>
                                    <td>' . $data->satuan . '</td>
                                    <td>Rp ' . number_format($data->harga_total, 2, ',', '.') . '</td>
                                </tr>';
                        $total += $data->harga_total;
                    }
                    $html .= '<tr>
                                <td colspan="4" align="right"><b>Total</b></td>
                                <td><b>Rp ' . number_format($total, 2, ',', '.') . '</b></td>
                            </tr>';
                    $html .= '</table>';
                    $html .= '<br/><br/><br/>';
                }
            } else if ($laporan == "Pemasukan") {
                $html .= '<table cellpadding="5" border="0.5">
                        <tr>';
                foreach ($table as $col) {
                    $html .= "<th align='center'><b>" . $col . "</b></th>";
                }
                $html .= '</tr>';

                // <th width="45%" align="center"><b>Nama Sampah</b></th>
                // <th width="15%" align="center"><b>Total Berat</b></th>
                // <th width="10%" align="center"><b>Satuan</b></th>
                // <th width="20%" align="center"><b>Total Harga</b></th>
                $no = 1;
                foreach ($listLaporan as $data) {
                    $html .= '<tr>
                                <td align="center">' . $no++ . '</td>
                                <td>' . ($data->j_name ? $data->j_name : "-") . '</td>
                                <td>' . $data->pm_hasil . '</td>
                                <td>' . $data->pm_jumlah . '</td>
                                <td>Rp' . number_format($data->pm_total, 2, ',', '.') . '</td>
                                <td>' . $data->pm_created_at . '</td>
                            </tr>';
                }
                $html .= '</table>';
            } else if ($laporan == "Pengeluaran") {
                $html .= '<table cellpadding="5" border="0.5">
                        <tr>';
                foreach ($table as $col) {
                    $html .= "<th align='center'><b>" . $col . "</b></th>";
                }
                $html .= '</tr>';

                // <th width="45%" align="center"><b>Nama Sampah</b></th>
                // <th width="15%" align="center"><b>Total Berat</b></th>
                // <th width="10%" align="center"><b>Satuan</b></th>
                // <th width="20%" align="center"><b>Total Harga</b></th>
                $no = 1;
                foreach ($listLaporan as $data) {
                    $html .= '<tr>
                                <td align="center">' . $no++ . '</td>
                                <td>' . $data->pk_bulan . '</td>
                                <td>' . $data->pk_jenis . '</td>
                                <td>' . $data->pk_jumlah . '</td>
                                <td>Rp' . number_format($data->pk_harga, 2, ',', '.') . '</td>
                                <td>Rp' . number_format($data->pk_total, 2, ',', '.') . '</td>
                                <td>' . ($data->un_name ? $data->un_name : "-") . '</td>
                                <td>' . ($data->pk_keterangan ? $data->pk_keterangan : "-") . '</td>
                            </tr>';
                }
                $html .= '</table>';
            } else if ($laporan == "Nasabah") {
                $html .= '<table cellpadding="5" border="0.5">
                        <tr>';
                foreach ($table as $col) {
                    $html .= "<th align='center'><b>" . $col . "</b></th>";
                }
                $html .= '</tr>';
                // <th width="45%" align="center"><b>Nama Sampah</b></th>
                // <th width="15%" align="center"><b>Total Berat</b></th>
                // <th width="10%" align="center"><b>Satuan</b></th>
                // <th width="20%" align="center"><b>Total Harga</b></th>
                $no = 1;
                foreach ($listLaporan as $data) {
                    $html .= '<tr>
                                <td align="center">' . $no++ . '</td>
                                <td>' . $data->n_name . '</td>
                                <td>' . $data->n_dob . '</td>
                                <td>' . $data->n_address . '</td>
                                <td>' . $data->n_city . '</td>
                                <td>' . $data->n_province . '</td>
                                <td>' . $data->n_postcode . '</td>
                                <td>' . $data->n_contact . '</td>
                                <td>' . $data->n_balance . '</td>
                                <td>' . $data->n_created_at . '</td>
                            </tr>';
                }
                $html .= '</table>';
            }
        } else {
            $html .= '<h1>Tidak Ada Data ' . $laporan . '</h1>';
        }

        $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->Output('Laporan BASADA.pdf', 'I');
    }
}

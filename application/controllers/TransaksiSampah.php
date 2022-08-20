<?php

defined('BASEPATH') or exit('No direct script access allowed');
class TransaksiSampah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Unit_model');
        $this->load->model('Auth_model');
        $this->load->model('Pemasukan_model');
        $this->load->library('Excel');
    }

    function index()
    {
        $data = array(
            'title' => 'Transaksi Penjualan Sampah',
            'active' => 'Transaksi Penjualan Sampah',
            'user' => _get_user($this)
        );
        wrapper_templates($this, "transaksi/sampah", $data);
    }

    function downloadExcel()
    {
        $table = [
            ["alphabet" => "A", "column" => "No"],
            ["alphabet" => "B", "column" => "Jenis Sampah"],
            ["alphabet" => "C", "column" => "Nama Pelapak"],
            ["alphabet" => "D", "column" => "Jumlah"],
            ["alphabet" => "E", "column" => "Total"],
            ["alphabet" => "F", "column" => "Keterangan"]
        ];
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('BASADA')
            ->setTitle("Data Transaksi Sampah")
            ->setSubject("Transaksi")
            ->setDescription("Laporan Riwayat Transaksi");
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
        foreach ($table as $value) {
            $excel->setActiveSheetIndex(0)->setCellValue($value["alphabet"] . '1', $value["column"]);
            $excel->getActiveSheet()->getStyle($value["alphabet"] . '1')->applyFromArray($style_col);
        }
        // $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        // $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        // $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        // $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $transaksi = $this->Pemasukan_model->get_transaksi();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
        foreach ($transaksi as $data) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->j_name);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->p_nama);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->pm_jumlah);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->pm_total);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->pm_hasil);
            foreach ($table as $value) {
                $excel->getActiveSheet()->getStyle($value["alphabet"] . $numrow)->applyFromArray($style_row);
            }
            $excel->getActiveSheet()->getStyle('E' . $numrow)->getNumberFormat()->setFormatCode("_(\"Rp\"* #,##0.00_);_(\"Rp\"* \(#,##0.00\);_(\"Rp\"* \"-\"??_);_(@_)");
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        foreach ($table as $value) {
            $excel->getActiveSheet()->getColumnDimension($value['alphabet'])->setAutoSize(true);
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Riwayat Transaksi");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Riwayat Transaksi.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}

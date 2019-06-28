 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart
{
	public function get_chart(){
        $cek=0;
        $select=0;
        $no=0;

        // harga
        // perulangan bulan
        $total=date('m')-12;
        $c_tahun=($total < 0 ? 0 : 12 );
        $no=0;
        $thn=date("Y")-1;
        for ($x = $total; $x < 100; $x++) {
            

            $month_html[$no]=date("F ", mktime(0, 0, 0, $x, 1,$select)).''.$thn;

            if ($x == $c_tahun) {
                $thn++;
            }
            if ($no >= 12) {
                break;
            }
            $no++;
            
        }
        return $month_html; 
    }

	

}

/* End of file chart.php */
/* Location: ./application/libraries/chart.php */

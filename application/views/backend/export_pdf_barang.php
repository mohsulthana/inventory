
    <link href="<?php echo base_url('assets/dashboard/');?>css/bootstrap.min.css" rel="stylesheet" />
    <table id="data-table-basic" class="table table-striped">
                                <thead class="text-center">
                                      <tr>
                                        <th width="10px">No.</th>
                                        <th >Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Ruangan</th>
                                        <th>Jenis</th>
                                        <th>Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $no=1; 
                                    foreach ($barang->result() as $key => $value) {
                                     ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td><?php echo $value->kode_inventaris; ?></td>
                                        <td><?php echo $value->nama; ?></td>
                                        <td><?php echo $value->jumlah; ?></td>
                                        <td><?php echo $value->nama_ruang; ?></td>
                                        <td><?php echo $value->nama_jenis; ?></td>
                                        <td><?php echo date("d / F / Y",strtotime($value->tanggal_register)); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>

                            <style type="text/css">
                                *{
                                    font-size: 9px;    
                                }
                            </style>
<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Register -->
			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('employer/tambah_employee/', $attributes, $hidden);?>	


                <input type="hidden" name="hrpremium_view" value="1" />
                <input type="hidden" name="company_id" value="2" />

<!-- 
                <p class="form-row form-row-wide" style="text-align: center;">
					<img src="<?php //echo base_url();?>skin/img/inka.png" alt="" style="width: 200px;"/>
				</p>
 -->

 <table border="1" style="border-style: solid; border-color: coral;">

        <tr>
            <td>NAMA LENGKAP&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $sign_fullname;?></b></td>
        </tr>
        <tr>
            <td>NIP&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $sign_nip;?></b></td>
        </tr>
        <tr>
            <td>JABATAN&ensp;&ensp;&ensp;</td>
            <td><b> : SENIOR MANAGER HRD</b></td>
        </tr>
        <tr>
            <td>PERUSAHAAN&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $sign_company[0]->name;?></b></td>
        </tr>
        <tr>
            <td>LOKASI&ensp;&ensp;&ensp;</td>
            <td><b> : INHOUSE</b></td>
        </tr>
        <tr>
            <td>NO DOKUMEN&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $nodoc;?></b></td>
        </tr>
        <tr>
            <td>TANGGAL TERBIT&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $release_date;?></b></td>
        </tr>
    </table>

<br>
 <table border="1" cellpadding="2" cellspacing="0" border="1" style="text-align: justify; text-justify: inter-word;">
        <tr>
            <td><b>INFORMASI DATA INI DIPERGUNAKAN SEBAGAI ALAT UNTUK PEMBERIAN INFORMASI DALAM RANGKA SURAT MENYURAT DAN MEMILIKI KEKUATAN HUKUM YANG SETARA DAN DAPAT DIPERTANGGUNG JAWABKAN.</b></td>
        </tr>
    </table>
<br>

 <table border="1" cellpadding="2" cellspacing="0" border="1" style="text-align: justify; text-justify: inter-word;">
        <tr>
            <td><b>Powerdby LEGAL @2022</b></td>
        </tr>
    </table>


				</form>
			</div>
		</div>
	</div>
</div>

<!-- Container -->
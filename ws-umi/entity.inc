####################### DB Connection #######################
DBTYPE = mysql
DBNAME = reportbav
DBUSER = root
DBHOST = 127.0.0.1
DBPORT = 3306
DBPASS = 

###################### DB Configuration ######################
tblmoddate      = umi_ts
tblpenyaluran   = umi_noa
tblpembiayaan   = umi_akad
tbltagihan      = umi_tagihan
tblpenyalur     = umi_penyalur 
tbloverview     = umi_overview 

############################# LOG #############################
logDir = ./log/umi-scheduler-log.txt

########################### OTHERS ###########################
API_umi         = http://localhost:5000/bav
path_penyalur   = listlinkage
path_akad       = akadpenyalur
path_tagihan    = tagihan
path_noa        = listdebtor
path_osdebtor   = osdebtor

sleepsec = 10


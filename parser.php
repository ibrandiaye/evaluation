<?php
$qcmLine = file_get_contents('d:/enda/questionnaire/qcm.txt');
$qcmCells = explode("\r\x07", $qcmLine);
$qcmText = end($qcmCells); // The last cell contains all the QCM text!
file_put_contents('d:/enda/evaluation-plateforme/qcm_raw.txt', $qcmText);

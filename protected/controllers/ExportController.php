<?php
/**
 * Export controller
 *
 * @author Taj
 *
 */
class ExportController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'     => array('*'),
            ),
        );
    }

    /**
     * Lists all user's projects.
     */
    public function actionIndex()
    {
        require_once(dirname(__FILE__).'/../extensions/PHPExcel/PHPExcel.php');

        /// get project's evaluation
        $Project = Project::getActive();
        $eval = $Project->getEvaluationArray(0.9, true);

        // get php excel
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("ODESYS")
                                     ->setLastModifiedBy("ODESYS")
                                     ->setTitle('ODESYS Project ' . CHtml::encode($Project->title))
                                     ->setSubject("ODESYS Project")
                                     ->setDescription("Data exported from http://www.odesys.info/, Online Decision Support System")
                                     ->setKeywords("ODESYS decision support web system")
                                     ->setCategory("Decision support");

         // automagically set column dimension
         foreach(range('A','Z') as $L)
         {
            $objPHPExcel->getActiveSheet()->getColumnDimension($L)->setAutoSize(true);

         }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ODESYS Project:')
                    ->setCellValue('B1', CHtml::encode($Project->title));

        $i = 4;
        foreach($eval as $id => $Alternative)
        {
            // write alternative names
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, CHtml::encode($Alternative['Obj']->title));

            // set to start from cell B (character 66)
            $j = 66;
            $k = 66;
            foreach($Alternative['Criteria'] as $C)
            {
                // write criteria titles
                if($i == 4)
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($j) . ($i - 1) , CHtml::encode($C['Obj']->title));
                    $j++;
                }

                // fill table
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($k) . ($i) , $C['Evaluation']->grade);
                $k++;
            }

            // write totals
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($k + 1) . 3 , 'Total:');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($k + 1) . ($i) , $Alternative['total']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($k + 2) . 3 , 'Weighted total:');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($k + 2) . ($i) , $Alternative['weightedTotal']);

            $i++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . (count($Project->alternatives) + 7), 'Weights:');
        $i = 65;
        $j = 1;
        $k = 0;
        foreach($Project->findCriteriaByPriority() as $C)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($i) . (count($Project->alternatives) + 8), CHtml::encode($C->title));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(chr($i) . (count($Project->alternatives) + 9), pow(0.9, $k));
            $i++;
            $k++;
            $j++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    }
}
<?php

namespace Project\Core;

use Bitrix\Main\Loader,
    CFormField,
    CFormAnswer,
    CFormResult,
    CFormStatus,
    CForm;

class Form {

    static public function add($FORM_ID, $arData) {
        if (Loader::includeModule('form')) {
            $formData = array();
            $arForm = CForm::GetByID_admin($FORM_ID);
            $default_status = CFormStatus::GetDefault($FORM_ID);
            $formData['status_' . $arForm['SID']] = CFormStatus::GetDefault($FORM_ID);

            $rsQuestions = CFormField::GetList($FORM_ID);
            while ($arQuestion = $rsQuestions->Fetch()) {
                if ($arQuestion['ADDITIONAL'] == 'Y') {
                    $formData['form_textarea_ADDITIONAL_' . $arQuestion['ID']] = $arData[$arQuestion['VARNAME']] ?: '';
                } else {
                    $formData['form_' . $arQuestion['FIELD_TYPE'] . '_' . $arQuestion['ID']] = $arData[$arQuestion['VARNAME']] ?: '';
                }
            }
            $CFormResult = new CFormResult;
            $RESULT_ID = $CFormResult->Add($FORM_ID, $formData, 'N');
            if ($RESULT_ID) {
                CFormResult::Update($RESULT_ID, $formData, 'Y', 'N');
                CFormCRM::onResultAdded($FORM_ID, $RESULT_ID);
                CFormResult::SetEvent($RESULT_ID);
                CFormResult::Mail($RESULT_ID);
            } else {
                global $strError;
            }
            return $RESULT_ID;
        }
        return false;
    }

}

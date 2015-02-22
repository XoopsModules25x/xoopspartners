<?php
/**
 * Xoops Partners Contents Class
 *
 * LICENSE
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      Andricq Nicolas (AKA MusS)
 * @version     $Id: category.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";

class XoopspartnersCategory extends XoopsObject
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->XoopsObject();
        $this->initVar( 'cat_id', XOBJ_DTYPE_INT, null, false );
        $this->initVar( 'cat_title', XOBJ_DTYPE_TXTBOX, null, false );
        $this->initVar( 'cat_description', XOBJ_DTYPE_TXTAREA, null, false );
        $this->initVar( 'cat_weight', XOBJ_DTYPE_INT, 0, false, 10 );
        $this->initVar( 'dohtml', XOBJ_DTYPE_INT );
        $this->initVar( 'doxcode', XOBJ_DTYPE_INT );
        $this->initVar( 'dosmiley', XOBJ_DTYPE_INT );
        $this->initVar( 'doimage', XOBJ_DTYPE_INT );
        $this->initVar( 'dobr', XOBJ_DTYPE_INT );
    }
    function XoopspartnersCategory() {
        $this->__construct();
    }

    function displayAdminForm($mode='add'){
        // Create Form Partner
        $title = ($mode == 'add') ? _XO_AD_ADD_CATEGORY : _XO_AD_EDIT_CATEGORY ;
        $form = new XoopsThemeForm( $title, 'partner', 'partners.php', 'post', true );
        $form->setExtra('enctype="multipart/form-data"');
        // Type
        if ($mode == 'add') {
            $type = new XoopsFormSelect( _XO_AD_TYPE, 'formtype', 'category');
            $type->addOption('category', _XO_AD_CATEGORY);
            $type->addOption('partners', _XO_AD_PARTNER);
            $type->setExtra( "onchange='submit()'" );
            $form->addElement($type);
        }
        // Title
        $form->addElement( new XoopsFormText( _XO_AD_TITLE, 'cat_title', 50, 50, $this->getVar('cat_title')), true );
        // Editor
        $editor_tray = new XoopsFormElementTray( _XO_AD_DESCRIPTION, '<br />' );
        if ( class_exists( 'XoopsFormEditor' ) ) {
            $configs=array(
                'name'   => 'cat_description',
                'value'  => $this->getVar('cat_description', 'e'),
                'rows'   => 25,
                'cols'   => '100%',
                'width'  => '100%',
                'height' => '250px',
                'editor' => xoopsPartners_setting('editor')
            );
            $editor_tray->addElement( new XoopsFormEditor( '', 'cat_description', $configs, false, $onfailure = 'textarea' ));
        } else {
            $editor_tray->addElement( new XoopsFormDhtmlTextArea( '', 'cat_description', $this->getVar( 'cat_description', 'e' ), '100%', '100%' ) );
        }
        $editor_tray->setDescription( _XO_AD_DESCRIPTION_DSC );
        if ( !xoopsPartners_isEditorHTML() ) {
            if ( $this->isNew() ) {
                $this->setVar( 'dohtml', 0 );
                $this->setVar( 'dobr', 1 );
            }
            // HTML
            $html_checkbox = new XoopsFormCheckBox( '', 'dohtml', $this->getVar( 'dohtml', 'e' ) );
            $html_checkbox->addOption( 1, _XO_AD_DOHTML );
            $editor_tray->addElement( $html_checkbox );
            // Break line
            $breaks_checkbox = new XoopsFormCheckBox( '', 'dobr', $this->getVar( 'dobr', 'e' ) );
            $breaks_checkbox->addOption( 1, _XO_AD_BREAKS );
            $editor_tray->addElement( $breaks_checkbox );
        } else {
            $form->addElement( new xoopsFormHidden( 'dohtml', 1 ) );
            $form->addElement( new xoopsFormHidden( 'dobr', 0 ) );
        }
        // Xoops Image
        $doimage_checkbox = new XoopsFormCheckBox( '', 'doimage', $this->getVar( 'doimage', 'e' ) );
        $doimage_checkbox->addOption( 1, _XO_AD_DOIMAGE );
        $editor_tray->addElement( $doimage_checkbox );
        // Xoops Code
        $xcodes_checkbox = new XoopsFormCheckBox( '', 'doxcode', $this->getVar( 'doxcode', 'e' ) );
        $xcodes_checkbox->addOption( 1, _XO_AD_DOXCODE );
        $editor_tray->addElement( $xcodes_checkbox );
        // Xoops Smiley
        $smiley_checkbox = new XoopsFormCheckBox( '', 'dosmiley', $this->getVar( 'dosmiley', 'e' ) );
        $smiley_checkbox->addOption( 1, _XO_AD_DOSMILEY );
        $editor_tray->addElement( $smiley_checkbox );
        // Editor and options
        $form->addElement( $editor_tray );
        // Weight
        $form->addElement( new XoopsFormText( _XO_AD_WEIGHT, 'cat_weight', 3, 10, $this->getVar('cat_weight')) );
        // Hidden value
        $form->addElement( new XoopsFormHidden( 'cat_id', $this->getVar('cat_id')) );
        $form->addElement( new XoopsFormHidden( 'type', 'category') );
        $form->addElement( new XoopsFormHidden( 'op', 'save') );
        $form->addElement( new XoopsFormButton( '', 'post', _SUBMIT, 'submit') );
        // Display form
        $form->display();
    }

}

class XoopspartnersCategoryHandler extends XoopsPersistableObjectHandler {
    /**
     * Construct
     *
     * @param mixed $db
     */
    function __construct( &$db ) {
        parent::__construct( $db, 'partners_category', 'XoopspartnersCategory', 'cat_id', 'cat_title' );
    }
    function XoopspartnersCategoryHandler( &$db ) {
        $this->__construct( $db );
    }
    
    /**
     * Return category order by weight
     *
     * @return
     */
    function &getObj() {
        $myts = &MyTextSanitizer::getInstance();
        $obj = false;
        $criteria = new CriteriaCompo();
        $criteria->setOrder( 'ASC' );
        $criteria->setSort( 'cat_weight' );
        
        $obj['count'] = $this->getCount( $criteria );
        $obj['list'] = &$this->getObjects( $criteria, false );
        return $obj;
    }
}
?>
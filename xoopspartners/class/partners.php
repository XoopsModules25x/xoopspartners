<?php
/**
 * Xoops Partners Partners Class
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
 * @version     $Id: partners.php 8212 2011-11-07 04:37:28Z beckmi $
 * @since       2.3.0
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";

class XoopspartnersPartners extends XoopsObject
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->XoopsObject();
        $this->initVar( 'id', XOBJ_DTYPE_INT, null, false );
        $this->initVar( 'title', XOBJ_DTYPE_TXTBOX, null, false );
        $this->initVar( 'description', XOBJ_DTYPE_TXTAREA, null, false );
        $this->initVar( 'url', XOBJ_DTYPE_TXTBOX, null, true );
        $this->initVar( 'image', XOBJ_DTYPE_TXTBOX, null, true );
        $this->initVar( 'weight', XOBJ_DTYPE_INT, 0, false, 10 );
        $this->initVar( 'hits', XOBJ_DTYPE_INT, 0, true, 10 );
        $this->initVar( 'status', XOBJ_DTYPE_INT, 1, false );
        $this->initVar( 'approve', XOBJ_DTYPE_INT, 1, false );
        $this->initVar( 'category_id', XOBJ_DTYPE_INT, null, false );
        $this->initVar( 'dohtml', XOBJ_DTYPE_INT );
        $this->initVar( 'doxcode', XOBJ_DTYPE_INT );
        $this->initVar( 'dosmiley', XOBJ_DTYPE_INT );
        $this->initVar( 'doimage', XOBJ_DTYPE_INT );
        $this->initVar( 'dobr', XOBJ_DTYPE_INT );
    }
    
    /**
     * Constructor
     */
    function XoopspartnersPartners() {
        $this->__construct();
    }

    /**
     * Display the partner form for admin area
     *
     */
    function displayJoinForm ($mode='add') {
        $category_handler = &xoops_getModuleHandler( 'category' );
        if ( !$category_handler->getCount() ) {
            xoops_error('index.php', 3, _XO_MD_ERRORNOCAT);

            return;
        }
        // Create Form Partner
        $title = _XO_MD_JOIN;
        $form = new XoopsThemeForm( $title, 'partner', 'join.php', 'post', true );
        $form->setExtra('enctype="multipart/form-data"');

        $objects = $category_handler->getList(); ;
        $category = new XoopsFormSelect( _XO_AD_CATEGORY, 'category_id', $this->getVar( 'category_id', 'e' ), 1, false );
        $category->addOptionArray( $objects );
        $form->addElement( $category );
        // Title
        $form->addElement( new XoopsFormText( _XO_AD_TITLE, 'title', 50, 50, $this->getVar('title')), true );
        // URL
        $form->addElement( new XoopsFormText( _XO_AD_URL, 'url', 50, 150, $this->getVar('url')), true );
        // Logo
        $form->addElement( new XoopsFormText( _XO_AD_IMAGE, 'image', 50, 150, $this->getVar('image')) );
        // Editor
        $editor_tray = new XoopsFormElementTray( _XO_AD_DESCRIPTION, '<br />' );
        if ( class_exists( 'XoopsFormEditor' ) ) {
            $configs=array(
                'name'   => 'description',
                'value'  => $this->getVar('description'),
                'rows'   => 25,
                'cols'   => '100%',
                'width'  => '100%',
                'height' => '250px',
                'editor' => xoopsPartners_setting('editor')
            );
            $editor_tray->addElement( new XoopsFormEditor( '', 'description', $configs, false, $onfailure = 'textarea' ));
        } else {
            $editor_tray->addElement( new XoopsFormDhtmlTextArea( '', 'description', $this->getVar( 'description', 'e' ), '100%', '100%' ) );
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
        // Hidden value
        $form->addElement( new XoopsFormHidden( 'weight', 0 ) );
        $form->addElement( new XoopsFormHidden( 'status', 0 ) );
        $form->addElement( new XoopsFormHidden( 'approve', 0 ) );
        $form->addElement( new XoopsFormHidden( 'id', $this->getVar('id')) );
        $form->addElement( new XoopsFormHidden( 'type', 'partners') );
        $form->addElement( new XoopsFormHidden( 'op', 'save') );
        $form->addElement( new XoopsFormButton( '', 'post', _SUBMIT, 'submit') );
        // Display form
        $form->display();
    }

    /**
     * Display the partner form for admin area
     *
     */
    function displayAdminForm ($mode='add') {
        $category_handler = &xoops_getModuleHandler( 'category' );
        if ( !$category_handler->getCount() ) {
            xoopsPartners_redirect('partners.php?op=' . $mode . '&amp;type=category', 3, _XO_AD_ERRORNOCAT);
            xoops_cp_footer();
            exit;
        }
        // Create Form Partner
        $title = ($mode == 'add') ? _XO_AD_ADD_PARTNER : _XO_AD_EDIT_PARTNER ;
        $form = new XoopsThemeForm( $title, 'partner', 'partners.php', 'post', true );
        $form->setExtra('enctype="multipart/form-data"');
        // Type
        if ($mode == 'add') {
            $type = new XoopsFormSelect( _XO_AD_TYPE, 'formtype', 'partners');
            $type->addOption('partners', _XO_AD_PARTNER);
            $type->addOption('category', _XO_AD_CATEGORY);
            $type->setExtra( "onchange='submit()'" );
            $form->addElement($type);
        }
        $objects = $category_handler->getList(); ;
        $category = new XoopsFormSelect( _XO_AD_CATEGORY, 'category_id', $this->getVar( 'category_id', 'e' ), 1, false );
        $category->addOptionArray( $objects );
        $form->addElement( $category );
        // Title
        $form->addElement( new XoopsFormText( _XO_AD_TITLE, 'title', 50, 50, $this->getVar('title')), true );
        // URL
        $form->addElement( new XoopsFormText( _XO_AD_URL, 'url', 50, 150, $this->getVar('url')), true );
        // Logo
        $form->addElement( new XoopsFormText( _XO_AD_IMAGE, 'image', 50, 150, $this->getVar('image')) );
        // Editor
        $editor_tray = new XoopsFormElementTray( _XO_AD_DESCRIPTION, '<br />' );
        if ( class_exists( 'XoopsFormEditor' ) ) {
            $configs=array(
                'name'   => 'description',
                'value'  => $this->getVar('description'),
                'rows'   => 25,
                'cols'   => '100%',
                'width'  => '100%',
                'height' => '250px',
                'editor' => xoopsPartners_setting('editor')
            );
            $editor_tray->addElement( new XoopsFormEditor( '', 'description', $configs, false, $onfailure = 'textarea' ));
        } else {
            $editor_tray->addElement( new XoopsFormDhtmlTextArea( '', 'description', $this->getVar( 'description', 'e' ), '100%', '100%' ) );
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
        $form->addElement( new XoopsFormText( _XO_AD_WEIGHT, 'weight', 3, 10, $this->getVar('weight')) );
        // Status
        $status = new XoopsFormSelect( _XO_AD_STATUS, 'status', $this->getVar('status') );
        $status->addOption( '1', _XO_AD_ACTIVE );
        $status->addOption( '0', _XO_AD_INACTIVE );
        $form->addElement( $status );
        // Hidden value
        $form->addElement( new XoopsFormHidden( 'approve', 1) );
        $form->addElement( new XoopsFormHidden( 'id', $this->getVar('id') ) );
        $form->addElement( new XoopsFormHidden( 'type', 'partners') );
        $form->addElement( new XoopsFormHidden( 'op', 'save') );
        $form->addElement( new XoopsFormButton( '', 'post', _SUBMIT, 'submit') );
        // Display form
        $form->display();
    }
}

/**
 * XoopspartnersPartnersHandler
 *
 * @package     XoopsPartners
 * @author      Andricq Nicolas (AKA MusS)
 * @copyright   Copyright (c) 2009
 * @version     $Id: partners.php 8212 2011-11-07 04:37:28Z beckmi $
 * @access      public
 */
class XoopspartnersPartnersHandler extends XoopsPersistableObjectHandler {
    /**
     * Constructor
     *
     * @param mixed $db
     */
    function __construct( &$db ) {
        parent::__construct( $db, 'partners', 'XoopspartnersPartners', 'id', 'title' );
    }
    
    function XoopspartnersPartnersHandler( &$db ) {
        $this->__construct( $db );
    }
    
    /**
     * Return the list of partners order by weight
     *
     * @return
     */
    function &getObj() {
        $obj = false;
        $criteria = new CriteriaCompo();
        $obj['count'] = $this->getCount( $criteria );
        if ( !empty( $args[0] ) ) {
            $criteria->setSort( 'ASC' );
            $criteria->setOrder( 'weight' );
            $criteria->setStart( 0 );
            $criteria->setLimit( 0 );
        }
        $obj['list'] = &$this->getObjects( $criteria, false );

        return $obj;
    }
    
    /**
     * Return the list of partners for a category
     *
     * @return
     */
    function &getByCategory( $id = '' ) {
        $obj = false;
        $criteria = new CriteriaCompo();
        if ( !empty( $id ) ) {
            $criteria->add( new Criteria( 'category_id', $id, '=' ) );
        }
        $obj['count'] = $this->getCount( $criteria );
        if ( !empty( $args[0] ) ) {
            $criteria->setSort( 'ASC' );
            $criteria->setOrder( 'weight' );
            $criteria->setStart( 0 );
            $criteria->setLimit( 0 );
        }
        $obj['list'] = &$this->getObjects( $criteria, false );

        return $obj;
    }

    /**
     * Return active partner
     *
     * @return
     */
    function &getActive( $id = '' ) {
        $obj = false;
        $criteria = new CriteriaCompo();
        if ( !empty( $id ) ) {
            $criteria->add( new Criteria( 'category_id', $id, '=' ) );
        }
        $obj['count'] = $this->getCount( $criteria );
        if ( !empty( $args[0] ) ) {
            $criteria->setSort( 'ASC' );
            $criteria->setOrder( 'title' );
        }
        $obj['list'] = &$this->getObjects( $criteria, false );

        return $obj;
    }
    
    /**
     * Update counter when user click on link
     */
    function setHits ($id) {
        $db =& Database::getInstance();
        $db->queryF("UPDATE ".$db->prefix("partners")." SET hits=hits+1 WHERE id=$id");
    }
}

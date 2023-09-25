<?php
class ControllerExtensionModuleXBundle extends Controller {
    use OCM\Traits\Back\Controller\Common;
    use OCM\Traits\Back\Controller\Product;
    private $ext_key;
    private $ext_path;
    private $error = array(); 
    private $ocm;
    private $meta = array(
        'id'       => '37489',
        'type'     => 'module',
        'name'     => 'xbundle',
        'path'     => 'extension/module/',
        'title'    => 'X-Bundle',
        'version'  => '1.0.2',
        'ocmod'    => true,
        'event'    => true
    );
    /* Config with default values  Special keyword __LANG__ denotes array of languages e.g 'name' => array('__LANG__' => 'xyz') */
    private $setting = array(
        'xbundle_status' => '',
        'xbundle_text'   => array('__LANG__' => 'Bundle Product'),
        'xbundle_title'  => array('__LANG__' => 'Bundle Offer'),
        'xbundle_box'    => array(
            'width'    => 100,
            'height'   => 100,
            'size'     => 170,
            'selector' => '#content .row:after',
            'tab'      => 0,
            'css'      => ''
        )
    );
    private $events = array(
        array(
            'trigger' => 'admin/model/catalog/product/addProduct/after',
            'action'  => 'extension/module/xbundle/onAddEditProduct'
        ),
        array(
            'trigger' => 'admin/model/catalog/product/editProduct/after',
            'action'  => 'extension/module/xbundle/onAddEditProduct'
        ),
        array(
            'trigger' => 'admin/model/catalog/product/deleteProduct/after',
            'action'  => 'extension/module/xbundle/onDeleteProduct'
        )
    );
    private $tables = array(
        'xbundle'        => array(
            array('name' => 'discount', 'option' => 'varchar(200)')
        ),
        'xbundle_preset' => array()
    );
    public function __construct($registry) {
        parent::__construct($registry);
        $this->ocm = new OCM\Back($registry, $this->meta);
        $this->ext_path = $this->meta['path'] . $this->meta['name'];
        $this->ext_key = 'model_' . str_replace('/', '_', $this->ext_path);
        if ($this->config->get('config_theme') == 'journal3') {
            $this->setting['xbundle_box']['selector'] = '.product-info:after';
        }
    }
    public function index() {
        $ext_lang = $this->load->language($this->ext_path);
        $this->load->model($this->ext_path);
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        $data = array();
        $data = array_merge($data, $ext_lang);

        /* লাইসেন্স বেরিফিকেসন  */
        $rs = $this->ocm->rpd();
        $data['_v'] = $rs ? '' : $this->ocm->vs();
        /* লাইসেন্স শেষ */
        $this->ocm->checkOCMOD();
        $this->upgrade();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $presets = isset($this->request->post['preset']) ? $this->request->post['preset'] : array();
            $this->{$this->ext_key}->addPresets($presets);
            /* save config */
            $save = $this->ocm->setting->editSetting($this->setting);
            $this->model_setting_setting->editSetting($save['key'], $save['value']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->ocm->url->getExtensionURL());
        }
        $data['heading_title'] = $this->language->get('heading_title');
        $data['x_name'] = $this->meta['name'];
        $data['x_path'] = $this->meta['path'] . $this->meta['name'];
             
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->session->data['warning'])) {
            $data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        }
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->ocm->url->link('common/dashboard', '', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->ocm->url->getExtensionsURL()
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->ocm->url->getExtensionURL()
        );

        $data['action'] = $this->ocm->url->getExtensionURL();
        $data['cancel'] = $this->ocm->url->getExtensionsURL();

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $data['languages'] = $this->ocm->url->getLangImage($languages);
        $data['language_id'] = $this->config->get('config_language_id');

        $options = array();
        $status_options = array('1' => $data['text_enabled'], '0' => $data['text_disabled']);
        $options['status'] = $this->ocm->form->getOptions($status_options, 'none');
        /* set form data */
        $this->ocm->form->setLangs($ext_lang)->setOptions($options);

        $more_help = array();
        $data['more_help'] = json_encode($more_help);
        $data['oc_3_1'] = VERSION >= '3.1.0.0';

        $data['presets'] = $this->{$this->ext_key}->getPresets();
        $data['tpl'] = json_encode(array(
            'preset' => $this->getPresetData($data, true)
        ));
        $data['config'] = $this->getConfigForm($data);
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->ocm->view($this->ext_path, $data));
    }
    private function getConfigForm($data) {
        /* Set base name for form inputs */
        $setting = $this->ocm->setting->getSetting($this->setting, $data['languages']);

        $this->ocm->form->setBasename($this->ocm->prefix . 'xbundle_', 'prefix');
        $this->ocm->form->setPreset($setting)->setIDPostfix('');

        $return = '';
        $tabs = array(
            'tab-general' => $data['tab_general'],
            'tab-text' => $data['tab_text'],
            'tab-preset' => $data['tab_preset'],
            'tab-help' => $data['tab_help']
        );
        $return .= $this->ocm->misc->getTabs('config-tab', $tabs);
        $return .= '<div class="tab-content">';

        $return .= '<div class="tab-pane active" id="tab-general">';
        $return .= $this->ocm->form->get('select', 'status');

        $return .= $this->ocm->form->get('input', 'box[size]');
        $return .= $this->ocm->form->get('input', 'box[width]');
        $return .= $this->ocm->form->get('input', 'box[height]');

        $element = $this->ocm->misc->getHelpTag($data['help_box_selector']);
        $return .= $this->ocm->form->get('bare', array('name' => 'css_info', 'title' => '', 'label_col' => 0, 'element' => $element));
        $return .= $this->ocm->form->get('checkbox', array('name' => 'box[tab]', 'label' => $data['text_tab']));
        $return .= $this->ocm->form->get('input', 'box[selector]');
        $return .= $this->ocm->form->get('textarea', 'box[css]');
        
        $return .= '</div>';

        $return .= '<div class="tab-pane" id="tab-text">';
        $return .= $this->ocm->misc->getLangTabs('language_heading', $data['languages']);
        $active = ' active';
        $return .= '<div class="tab-content">';
        foreach ($data['languages'] as $language) { 
            $language_id = $language['language_id'];
            $return .= '<div class="tab-pane' . $active . '" id="language_heading' . '-' . $language_id . '">';
            $param = array(
                'name'  => 'title[' . $language_id . ']'
            );
            $return .= $this->ocm->form->get('input', $param);

            $param = array(
                'name'  => 'text[' . $language_id . ']',
                'required' => true
            );
            $return .= $this->ocm->form->get('input', $param);
            $return .= '</div>';
            $active = '';
        }
        $return .= '</div>';
        $return .= '</div>';

        $return .= '<div class="tab-pane" id="tab-preset">';
        $return .= $this->getPresetData($data);
        $return .= '<div class="preset-btn">'.$this->ocm->misc->getButton(array('type' => 'success', 'help'=> $data['text_preset_add'], 'class' => 'add-new-preset', 'icon' => 'fa-plus', 'title' => $data['text_preset_add'])).'</div>';
        $return .= '</div>';

        $return .= '<div class="tab-pane" id="tab-help">';
        $return .= $this->ocm->misc->getOCMInfo();
        $return .= '</div>';
        $return .= '</div>';

        return $return;
    }
    private function getPresetData($data, $new_preset = false) {
        $this->load->model($this->ext_path);
        if ($new_preset) {
            $data['presets'] = array(
              array('id' => '__INDEX__', 'products' => '', 'name' => '')
            );
        }
        $return = ''; 
        foreach($data['presets'] as $preset) {
            $preset_id = $preset['id'];
            $name = $preset['name'];
            $products = $this->{$this->ext_key}->getPresetProducts($preset_id);
            
            $return .='<div class="preset-container" rel="'.$preset_id.'" id="preset'.$preset_id.'">'
                  .'<div class="preset-delete">' . $this->ocm->misc->getButton(array('type' => 'danger', 'help'=> $data['text_preset_delete'], 'class' => 'remove-preset', 'icon' => 'fa-trash fa-trash-alt')) . '</div>'
                 .'<div class="form-group">'
                      .'<label class="col-sm-3 control-label" for="input-name'.$preset_id.'">'.$data['text_preset_name'].'</label>'
                  .'<div class="col-sm-7">
                     <input type="text" name="preset['.$preset_id.'][name]" value="'.$name.'" class="form-control" id="input-name'.$preset_id.'" />
                    </div>'
                .'</div>'

                .'<div class="table-responsive">'
                 .'<table class="table table-striped table-bordered table-hover products">'
                  .'<thead>'
                   .'<tr>'
                       .'<td class="text-left"><label class="control-label">'.$data['text_product_name'].'</label></td>'
                       .'<td width="150" class="text-center"><label class="control-label">'.$data['text_product_price'].'</label></td>'
                       .'<td width="300" class="text-left"><label class="control-label">'.$data['text_discount'].'</label> <input type="text" value="" placeholder="' . $data['text_change_bulk'] .'" class="form-control adjust-bulk" autocomplete="off"></td>'
                       .'<td width="80" class="text-right"><a data-toggle="tooltip" title="'.$data['text_remove_all'].'" class="btn btn-danger btn-sm ocm-row-remove-all" role="button"><i class="fa fas fa-times"></i></a></td>'
                   .'</tr>'
                  .'</thead>'
                  .'<tbody>';
                    $is_row_found=false;
                    foreach ($products as $product) { 
                       $is_row_found=true; 
                       $return .= '
                        <tr rel="'.$product['product_id'].'">' 
                          .'<td class="text-left">'.$product['name'].'</td>'
                          .'<td class="text-center">'.$product['price'].'</td>'
                          .'<td class="text-left"><input size="15" type="text" class="form-control product" rel="'.$product['product_id'].'" name="preset['.$preset_id.'][products]['.$product['product_id'].']" value="'.$product['discount'].'" /></td>'
                            .'<td class="text-right"><a data-toggle="tooltip" title="'.$data['text_remove'].'" class="btn btn-danger btn-sm ocm-row-remove"><i class="fa fas fa-times"></i></a></td>'
                        .'</tr>';
                    }
                    if (!$is_row_found) {
                        $return .='<tr class="no-row"><td colspan="4">'.$data['text_no_unit_row'].'</td></tr>';
                    }

                    $return .='</tbody>'
                  .'<tfoot>'
                    .'<tr>'
                     .'<td  colspan="4" class="text-right"><a class="btn btn-primary add-new"><i class="fa fa-plus-circle"></i>&nbsp;'.$data['text_add_new'].'</a></label>'
                    .'</tr>'
                   .'</tfoot>'
                 .'</table>'
                .'</div>'
                .'</div>';
            }
            return $return;
    }
    public function getBundleTab(){
        $this->load->model($this->ext_path);
        $ext_lang = $this->load->language($this->ext_path);

        $data = array();
        $data = array_merge($data, $ext_lang);
        $product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;
        $data['product_id'] = $product_id;
        $data['x_name'] = $this->meta['name'];
        $data['x_path'] = $this->meta['path'] . $this->meta['name'];

        //add bundle here if it fails due to validation
        if ($product_id && ($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $bundle_products = isset($this->request->post[$this->meta['name']]) ? $this->request->post[$this->meta['name']] : array();
            $this->{$this->ext_key}->addBundle($product_id, $bundle_products);
        }

        $results = $this->{$this->ext_key}->getBundles($product_id);
        $data['bundle_products'] = array();
        foreach ($results as $result) {
            /* latency version - will remove in future  */
            if (!$result['discount'] && !empty($result['price'])) {
                $result['discount'] = (float)$result['actual_price'] - (float)$result['price'];
            }
            /* end of latency */
            $data['bundle_products'][] = array(
                'product_id'   => (int)$result['bundle_id'],
                'name'         => $result['name'],
                'price'        => (float)$result['actual_price'],
                'discount'     => $result['discount'],
                'bundle'       => $this->{$this->ext_key}->getDiscountedPrice($result['discount'], (float)$result['actual_price'])
            );
        }
        $presets = $this->{$this->ext_key}->getPresets();
        $data['presets'] = array();
        foreach ($presets as $preset) {
            $data['presets'][] =  array(
                'id'         => $preset['id'],
                'name'         => $preset['name']
            );
        }
        return $this->ocm->view($this->meta['path'] . 'xbundle_tab', $data);
    }
    public function getPreset() {
        $this->load->model($this->ext_path);
        $preset_id = isset($this->request->get['preset_id']) ? $this->request->get['preset_id'] : 0;
        $json = $this->{$this->ext_key}->getPresetProducts($preset_id);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    /* Event function */
    public function onAddEditProduct($route, $response, $product_id) {
        $this->load->model($this->ext_path);
        $bundle_products = isset($this->request->post[$this->meta['name']]) ? $this->request->post[$this->meta['name']] : array();
        if (VERSION >= '2.3.0') {
            if (strpos($route, 'addProduct') === false) $product_id = $response[0];
        } else {
            if (strpos($route, 'addProduct') === true) $product_id = $response;
        }
        $this->{$this->ext_key}->addBundle($product_id, $bundle_products);
    }
    public function onDeleteProduct($route, $response, $product_id = 0) {
        $this->load->model($this->ext_path);
        if (VERSION >= '2.3.0') {
            $product_id = isset($response[0]) ? $response[0] : 0;
        }
        if ($product_id) {
            $this->{$this->ext_key}->deleteBundle($product_id);
        }
    }
    /* End of events*/
}
<?php
namespace ElementorDDMG\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class meet_founders extends Widget_Base {

    public function get_name() {
        return 'ddmg-meetfounders';
    }

    public function get_title() {
        return __('Meet Founders', 'ddmg');
    }

    public function get_icon() {
        return 'eicon-favorite wts-eae-pe';
    }

    public function get_categories() {
        return ['ddmg-category'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Meet Founders', 'ddmg'),
            ]
        );

        $this->add_control(
            'founderimg', [
                'label'             => __( 'Upload Image', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::MEDIA,
                'default'           => [
                    'url'               => '',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label'             => __('Title', 'ddmg'),
                'type'              => Controls_Manager::TEXT,
                'default'           => '',
                'label_block'       => true,
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'name', [
                'label'             => __( 'Name', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => '',
                'label_block'       => true,
            ]
        );
        $repeater->add_control(
            'designation', [
                'label'             => __( 'Designation', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => '',
                'label_block'       => true,
            ]
        );
        $repeater->add_control(
            'description', [
                'label'             => __( 'Description', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::TEXTAREA,
                'default'           => '',
                'label_block'       => true,
            ]
        );
        $this->add_control(
            'list',
            [
                'label'             => __( 'List', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::REPEATER,
                'fields'            => $repeater->get_controls(),
                'default'           => [
                    [
                        'name'         => __( 'List #1', 'ddmg' ),
                    ]
                ],
                'title_field'       => '{{{ name }}}',
            ]
        );
		$this->add_control(
            'sec_id', [
                'label'             => __( 'Section ID', 'ddmg' ),
                'type'              => \Elementor\Controls_Manager::TEXT,
                'default'           => '',
                'label_block'       => true,
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings             = $this->get_settings();
        $founderimg           = $this->get_settings('founderimg');
        $title                = $this->get_settings('title');
        $list                 = $this->get_settings('list');
		$sec_id               = $this->get_settings('sec_id');
        ?>
        <div id="<?php echo $sec_id ?>" class="founders-sec">
            <div class="founders-sec-inner flex-wrap">
                <?php 
                if($founderimg['url']){
                    ?>
                    <div class="founder-img"><img src="<?php echo $founderimg['url']; ?>" alt=""></div>
                    <?php
                }
                ?>
                <div class="founder-content">
                    <?php echo ($title != '') ? '<h2>'.$title.'</h2>' : ''; ?>
                    <div class="founder-slider owl-carousel">
                        <?php foreach($list as $r) : ?>
                        <div class="f-slide-item">
                            <h4><?php echo $r['name']; ?></h4>
                            <span class="designation"><?php echo $r['designation']; ?></span>
                            <p><span>"</span><?php echo $r['description']; ?><span>”</span></p>
                        </div>
                        <?php endforeach; ?>  
                    </div>
                    <div class="founder-slider-counter"></div>
                </div>
            </div>
        </div>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/owl.carousel.min.js"></script>
        <script>
            jQuery('.founder-slider').on('initialized.owl.carousel changed.owl.carousel', function(e) {
                if (!e.namespace) {
                    return;
                }
                let carousel = e.relatedTarget;
                let totalNumber = 0;
                let currentNumber = 0;
                if (carousel.items().length > 9) {
                    totalNumber = "";
                }
                if (carousel.current() >= 9) {
                    currentNumber = "";
                }
                let numbers = carousel.relative(carousel.current()) + 1 + '/' + totalNumber + carousel.items().length;
                jQuery('.founder-slider-counter').text(`${currentNumber}${numbers}`);
            }).owlCarousel({
                loop: false,
                margin: 30,
                autoplay: false,
                nav: true,
                dot: true,
                items: 1,
            });
        </script>
        <?php
    }

    protected function content_template() {

    }
}
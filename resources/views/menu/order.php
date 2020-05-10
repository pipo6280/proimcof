<?php
    use system\Helpers\Form;
    use app\dtos\UsuarioMenuDto;
    
    $object = $object instanceof UsuarioMenuDto ? $object : new UsuarioMenuDto();
?>
<style>
	#sortable, #sortable2 { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#sortable li, #sortable2 li { margin: 0 3px 3px 3px; border:#999 1px dotted; }
	#sortable li span, #sortable2 li span { position: absolute; margin-left: -1.3em; }
	#sortable li a, #sortable2 li a { float:right;  }
</style>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('menu.form_order', [$object->getNombre()]); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['action' => 'Menu@save_ordenar', 'id' => 'frmEditMenu','class' => 'col s12'])?>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6 col-lg-6">
                    <ul id="sortable">
                        <li id="1_0" value="0">
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                            <a class="classOrdenar" href="#">Barra Men&uacute;</a>
                        	<br />
                        </li>
                	    <?php foreach($object->getListMenus() as $lis) { ?> 
                	       <li id="1_<?php echo $lis->getId_menu(); ?>" value="<?php echo $lis->getOrden(); ?>">
                	           <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
        					   <?php echo $lis->getNombre(); ?> 
                        	   <a class="classOrdenar" href="#" data-id_menu="<?php echo $lis->getId_menu(); ?>" data-id_menu_padre="<?php echo $lis->getId_menu(); ?>">
                        	       <?php echo lang('menu.sub_menu'); ?>
                               </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="form-group col-xs-12 col-md-6 col-lg-6">
                    <ul id="sortable2">
                    	<?php foreach($object->getListHijosMenus() as $lis){ ?>
                        	<li id="2_<?php echo $lis->getId_menu(); ?>" value="<?php echo $lis->getOrden(); ?>">
                            	<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
        						<?php echo $lis->getNombre(); ?> 
                                <a class="classOrdenar" href="#" data-id_menu="<?php echo $lis->getId_menu(); ?>" data-id_menu_padre="<?php echo $lis->getId_menu(); ?>">
                                    <?php echo lang('menu.sub_menu'); ?>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="form-group col s12">
                    <?php 
                        echo Form::button(lang('general.order_button_icon'), [
                            'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                            'id' => 'btnOrderMenu'
                        ]);
                    ?>
                </div>
            </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    var id = '1_0';
    var valores = '';
    $('a.classOrdenar').each(function () {
		$(this).click(function (){
			var object = $(this);
			var data = object.data();
			Framework.setLoadData({
				pagina : '<?php echo base_url('menu/order'); ?>',
				data : {
					txtId_menu_padre : data.id_menu_padre,
					txtId_menu : data.id_menu					
				}
			});
		});
	});
    $( "#sortable2" ).sortable({
		change: function(event, ui){
			id = $(".ui-sortable-helper").attr('id');
		},
		stop: function() {
			$( ".ui-selectee", this ).each(function() {
				if(this.id != ""){
					var index = $( "#sortable2 li" ).index( $('#'+ this.id) );
					valores += this.id + "=" + (index+1) + ",";
					$('#'+ this.id).val(index+1);
				}
			});
			valores = valores.substr(0, valores.length-1);
		}
	}).selectable();
	$(this).disableSelection();
	$('#btnOrderMenu').click(function () {
		if ($.trim(valores) != '') {
			var l = Ladda.create(this);
            l.start();
			Framework.setLoadData({
				pagina : '<?php echo base_url('menu/save_order'); ?>',
				id_contenedor_body 	: false,
				data : {
					txtValores: valores
				},
				success : function(data) {
					Framework.setSuccess('Los menús han sido ordenados');
					Framework.setLoadData({
						pagina : '<?php echo base_url('menu/order'); ?>',
						data : {
							txtId_menu : null,
							txtId_menu_padre : null,
						}
					});
				}
			});
		} else  {
			Framework.setWarning('No ha efectuado ningún cambio');
		}
	});
});
</script>
<?php
use app\dtos\LoginDto;
use system\Support\Util;
use app\enums\EDateFormat;

$object = $object instanceof LoginDto ? $object : new LoginDto(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex,nofollow" />
        <meta property="og:title" content="My First Campaign" />
    </head>
    <!--[if mso]>
      <body class="mso">
    <![endif]-->
    <!--[if !mso]><!-->
        <body class="full-padding" style="margin: 0; padding: 0; min-width: 100%; background-color: #fbfbfb;">
    <!--<![endif]-->
    	<center class="wrapper" style="display: table; table-layout: fixed; width: 100%; min-width: 620px; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #fbfbfb;">
    		<table class="gmail" style="border-collapse: collapse; border-spacing: 0; width: 650px; min-width: 650px;">
    			<tbody>
    				<tr>
    					<td style="padding: 0; vertical-align: top; font-size: 1px; line-height: 1px;">&nbsp;</td>
    				</tr>
    			</tbody>
    		</table>
            <table class="preheader centered" style="border-collapse: collapse; border-spacing: 0; Margin-left: auto; Margin-right: auto;">
    			<tbody>
    				<tr>
    					<td style="padding: 0; vertical-align: top;">
    						<table style="border-collapse: collapse; border-spacing: 0; width: 602px;">
    							<tbody>
    								<tr>
    									<td class="title" style="padding: 0; vertical-align: top; font-family: Georgia, serif; color: #999; padding-top: 10px; padding-bottom: 12px; font-size: 12px; line-height: 21px; text-align: left;"> &nbsp;</td>
    									<td class="webversion" style="padding: 0; vertical-align: top; font-family: Georgia, serif; color: #999; padding-top: 10px; padding-bottom: 12px; font-size: 12px; line-height: 21px; text-align: right; width: 300px;"></td>
    								</tr>
    							</tbody>
    						</table>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    		<table class="header centered" style="border-collapse: collapse; border-spacing: 0; Margin-left: auto; Margin-right: auto; width: 602px;" id="emb-email-header-container">
    			<tbody>
    				<tr>
    					<td class="logo emb-logo-padding-box" style="padding: 0; vertical-align: top; mso-line-height-rule: at-least; padding-top: 6px; padding-bottom: 20px;">
                            <div class="logo-center" style="font-family: Avenir, sans-serif; color: #41637e; font-weight: 700; letter-spacing: -0.02em; text-align: center; font-size: 0px !important; line-height: 0 !important;" align="center" id="emb-email-header">
                                <img src="<?php echo site_url('public/img/login-logo.png')?>" alt="" style="border: 0; -ms-interpolation-mode: bicubic; display: block; Margin-left: auto; Margin-right: auto; max-width: 296px;" width="296" height="157" />
    						</div>
                        </td>
    				</tr>
    			</tbody>
    		</table>
    		<table class="centered" style="border-collapse: collapse; border-spacing: 0; Margin-left: auto; Margin-right: auto;">
    			<tbody>
    				<tr>
    					<td class="border" style="padding: 0; vertical-align: top; font-size: 1px; line-height: 1px; background-color: #e9e9e9; width: 1px;">&#8203;</td>
    					<td style="padding: 0; vertical-align: top;">
    						<table class="one-col" style="border-collapse: collapse; border-spacing: 0; Margin-left: auto; Margin-right: auto; width: 600px; background-color: #ffffff; font-size: 14px; table-layout: fixed;" emb-background-style>
    							<tbody>
    								<tr>
    									<td class="column" style="padding: 0; vertical-align: top; text-align: left;">
    										<?php /*?>
    										<div class="image" style="font-size: 12px; mso-line-height-rule: at-least; font-style: normal; font-weight: 400; Margin-bottom: 0; Margin-top: 0; font-family: Georgia, serif; color: #565656;" align="center">
                                                <img src="<?php echo site_url('public/img/4531a30c748f4602ae9e63a530a24d23.png'); ?>" alt="" style="border: 0; -ms-interpolation-mode: bicubic; display: block; max-width: 600px;" width="600" height="120" />
    										</div>
    										<?php */?>
    										<table class="contents" style="border-collapse: collapse; border-spacing: 0; table-layout: fixed; width: 100%;">
    											<tbody>
    												<tr>
    													<td class="padded" style="padding: 0; vertical-align: top; padding-left: 32px; padding-right: 32px; word-break: break-word; word-wrap: break-word;">
    														<h1 style="font-style: normal; font-weight: 700; Margin-bottom: 0; Margin-top: 24px; font-size: 36px; line-height: 44px; font-family: Avenir, sans-serif; color: #565656;">
                                                                Restablecimiento de contraseña
                                                            </h1>
    														<p style="font-style: normal; font-weight: 400; Margin-bottom: 0; Margin-top: 18px; line-height: 24px; font-family: Georgia, serif; color: #565656; font-size: 16px;">
                                                                Se ha generado una nueva contraseña provisional.
    												        </p>
    												        <p style="font-style: normal; font-weight: 400; Margin-bottom: 0; Margin-top: 18px; line-height: 24px; font-family: Georgia, serif; color: #565656; font-size: 16px;">
    												            Usuario del sistema: <strong><?php echo $object->getDto()->getLoggin(); ?></strong>
    												            <br>
                                                                Nueva contraseña: <strong><?php echo $object->getDto()->getPassword(); ?></strong>
    												        </p>
    												        <p style="font-style: normal; font-weight: 400; Margin-bottom: 0; Margin-top: 18px; line-height: 24px; font-family: Georgia, serif; color: #565656; font-size: 16px;">
    												            El sistema le solicitará el cambio de contraseña al momento de ingresar.
    												            <br>
                                                                Este mensaje ha sido enviado a la siguiente cuenta de correo: - <?php echo $object->getDto()->getPersonaDto()->getEmail(); ?> 
    												        </p>
    												        <p style="font-style: normal; font-weight: 400; Margin-bottom: 0; Margin-top: 18px; line-height: 24px; font-family: Georgia, serif; color: #565656; font-size: 16px;">
    												            Se le informa que la última vez que usted cambió su contraseña ó solicitó recuperación de la misma fue: <strong><?php echo Util::formatDate($object->getDto()->getFecha_modificacion(), EDateFormat::index(EDateFormat::MES_DIA_ANO_HORA)->getId()); ?></strong>
    												            <br>
                                                                Recuerde, cambie periódicamente su contraseña por su seguridad y la del sistema.
    												        </p>
    													</td>
    												</tr>
    											</tbody>
    										</table>
    										<div class="column-bottom" style="font-size: 32px; line-height: 32px; transition-timing-function: cubic-bezier(0, 0, 0.2, 1); transition-duration: 150ms; transition-property: all;">&nbsp;</div>
    									</td>
    								</tr>
    							</tbody>
    						</table>
    					</td>
    					<td class="border" style="padding: 0; vertical-align: top; font-size: 1px; line-height: 1px; background-color: #e9e9e9; width: 1px;">&#8203;</td>
    				</tr>
    			</tbody>
    		</table>

    		<table class="border" style="border-collapse: collapse; border-spacing: 0; font-size: 1px; line-height: 1px; background-color: #e9e9e9; Margin-left: auto; Margin-right: auto;" width="602">
    			<tbody>
    				<tr>
    					<td style="padding: 0; vertical-align: top;">&#8203;</td>
    				</tr>
    			</tbody>
    		</table>
    		
    		<table class="footer centered" style="border-collapse: collapse; border-spacing: 0; Margin-left: auto; Margin-right: auto; width: 100%;">
    			<tbody>
    				<tr>
    					<td style="padding: 0; vertical-align: top;">&nbsp;</td>
    					<td class="inner" style="padding: 58px 0 29px 0; vertical-align: top; width: 600px;">
    						<table class="left" style="border-collapse: collapse; border-spacing: 0;" align="left">
    							<tbody>
    								<tr>
    									<td style="padding: 0; vertical-align: top; color: #999; font-size: 12px; line-height: 22px; text-align: left; width: 400px;">
    										<div class="links emb-web-links" style="line-height: 26px; Margin-bottom: 26px; mso-line-height-rule: at-least;">
    								            <a style="transition: opacity 0.2s ease-in; color: #999; text-decoration: none;" href="https://www.youtube.com/channel/UCfeKuTU5KWbK7JomunAhq3Q">
    								                <img src="<?php echo site_url('public/img/twitter-sf.png'); ?>" alt="" style="border: 0; -ms-interpolation-mode: bicubic; vertical-align: middle;" width="29" height="26" />
    								            </a>
    								            <a style="transition: opacity 0.2s ease-in; color: #999; text-decoration: none;" href="http://www.margaritacovelli.com">
    								                <img src="<?php echo site_url('public/img/facebook-sf.png') ?>" alt="" style="border: 0; -ms-interpolation-mode: bicubic; vertical-align: middle;" width="29" height="26" />
    								            </a>
    								            <a style="transition: opacity 0.2s ease-in; color: #999; text-decoration: none;" href="http://www.margaritacovelli.com">
    								                <img src="<?php echo site_url('public/img/website-sf.png') ?>" alt="" style="border: 0; -ms-interpolation-mode: bicubic; vertical-align: middle;" width="29" height="26" />
    								            </a>
    										</div>
    										<div class="permission" style="font-family: Georgia, serif;">
    											<div>
                                                    <?php echo lang('login.message_not_answer'); ?>
    								            </div>
    										</div>
    									</td>
    								</tr>
    							</tbody>
    						</table>
                        </td>
                        <td style="padding: 0; vertical-align: top;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </center>
    </body>
</html>
<div class="wrap">
	<h1>V2RayQ Lite</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1"><?php echo __('Manage VMess', 'v2rayq-lite') ?></a></li> 
		<li><a href="#tab-2"><?php echo __('About', 'v2rayq-lite') ?> </a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active"> 
			
			<form method="post" action="options.php"> 
				<?php

				settings_fields( 'v2rayq_lite_settings' ); 
				do_settings_sections( 'v2rayq_lite' );

				submit_button();	 

				?>
			</form>

			<?php 

			if( file_exists('/etc/caddy/Caddyfile' ) AND file_exists('/etc/v2ray/config.json' ) ) {

				if(get_option('v2rayq_lite')['VMess'] && get_option('v2rayq_lite_domain') == get_option('v2rayq_lite')['domain']) {
					$v2rayq_vmess = get_option( 'v2rayq_lite' )['VMess'];
					$v2rayq_vmess = base64_decode($v2rayq_vmess);
					$v2rayq_vmess = nl2br($v2rayq_vmess);
					echo '<p><strong>Copy below to your applications:</strong></p>'.$v2rayq_vmess;

				}else{
					if(get_option('v2rayq_lite_domain')) {
						$v2rayq_lite_domain = get_option('v2rayq_lite_domain');
						$v2rayq_lite_domain = str_replace('https://', '', $v2rayq_lite_domain);
						$v2rayq_lite_domain = str_replace('http://', '', $v2rayq_lite_domain);

						$uuid = file_get_contents('/proc/sys/kernel/random/uuid');
						$uuid = preg_replace('/(\n)/', '', $uuid);

						$caddy_path = plugin_dir_path(dirname(__FILE__)).'inc/V2ray/caddy.txt';
						$v2ray_path = plugin_dir_path(dirname(__FILE__)).'inc/V2ray/v2ray.json';
						$keys_path = plugin_dir_path(dirname(__FILE__)).'inc/V2ray/keys.txt';

						$caddy = "sed 0,/20gjp1001.google.com/s//$v2rayq_lite_domain/1  $caddy_path";  
						$v2ray = "sed 0,/47010059-4706-459e-b506-7a073efcf1df/s//$uuid/1  $v2ray_path"; 

						$vmess_header = "ShadowRocket VMess Url:\n\n";
						$vmess_url1 = 'vmess://';
						$vmess_url2 = "chacha20-poly1305:$uuid@$v2rayq_lite_domain:443";
						$vmess_url3 = "?remarks=V2RayQ";
						$vmess_url4 = "&obfsParam=%7B%22Host%22:%22$v2rayq_lite_domain%22%7D";
						$vmess_url5 = '&path=/r2';
						$vmess_url6 = '&obfs=websocket';
						$vmess_url7 = '&tls=1';
						$vmess_url8 = "&peer=$v2rayq_lite_domain";
						$vmess_url9 = '&mux=1';
						$vmess_url10 = '&alterId=233';

						$vmess_url = $vmess_header.$vmess_url1.base64_encode($vmess_url2).$vmess_url3.
						$vmess_url4.$vmess_url5.$vmess_url6.$vmess_url7.$vmess_url8.$vmess_url9.$vmess_url10;
							//Change license keys from host and uuid.
                            // get license key from keys.txt
						$sed_keys = "sed '0,/20gjp1001.google.com/s//$v2rayq_lite_domain/1; 0,/47010059-4706-459e-b506-7a073efcf1df/s//$uuid/1' $keys_path";
						$v2rayq_vmess = $vmess_url."\n"."\n".shell_exec($sed_keys);	
						$v2rayq_vmess = base64_encode($v2rayq_vmess); 

						if (strpos(file_get_contents('/etc/caddy/Caddyfile'), $v2rayq_lite_domain) == false) {
							file_put_contents('/etc/caddy/Caddyfile', '');
							file_put_contents('/etc/v2ray/config.json', '');
							file_put_contents('/etc/caddy/Caddyfile', shell_exec($caddy ), FILE_APPEND | LOCK_EX);
							file_put_contents('/etc/v2ray/config.json', shell_exec($v2ray ), FILE_APPEND | LOCK_EX);
						} 
						update_option( 'v2rayq_lite', array('domain' => $v2rayq_lite_domain, 'VMess' => $v2rayq_vmess));  
						$v2rayq_vmess = get_option( 'v2rayq_lite' )['VMess'];
						$v2rayq_vmess = base64_decode($v2rayq_vmess);
						$v2rayq_vmess = nl2br($v2rayq_vmess);
						echo '<p><strong>Copy below to your applications:</strong></p>'.$v2rayq_vmess;
					}
				}
			}else{
				echo '<pre>'.'<p>***<strong> Caddy Server or V2Ray has not been installed. ***</strong></p>' .
				'<p>Please follow blow steps to install Caddy server and V2Ray.<p>'.
				'<p>1. Ensure your server system is Ubuntu 20+ or Debian 9+ (not test on other systems).</p>'.
				'<p>2. SSH Log into your server, and execute each command below.</p><br>'.
				'<p>  sudo apt -y update</p>'.
				'<p>  sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https</p>'.
				"<p>  curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg</p>".
				"<p>  curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list</p>".
				'<p>  sudo apt -y update</p>'.
				'<p>  sudo apt install -y caddy </p>'.
				'<p>  wget https://github.com/v2ray/v2ray-core/releases/download/v4.28.2/v2ray-linux-64.zip</p>'.
				'<p>  sudo apt install -y unzip</p>'.
				'<p>  sudo unzip -qq v2ray-linux-64.zip</p>'.
				'<p>  sudo mkdir -p /usr/bin/v2ray/</p>'.
				'<p>  sudo mkdir -p /etc/v2ray/</p>'.
				'<p>  sudo mkdir -p /var/log/v2ray/</p>'.
				'<p>  sudo mv v2ray v2ctl /usr/bin/v2ray/</p>'.
				'<p>  sudo mv config.json /etc/v2ray/</p>'.
				'<p>  sudo chmod +x /usr/bin/v2ray/*</p>'.
				"<p>  sudo mv v2ray.service /etc/systemd/system/v2ray.service</p>".
				'<p>  cd /etc/caddy/</p>'.
				'<p>  sudo chown -R www-data:www-data .</p>'.
				'<p>  cd /etc/v2ray/</p>'.
				'<p>  sudo chown -R www-data:www-data .</p>'.'</pre>'
				;
			}

			?>
		</div> 

		<div id="tab-2" class="tab-pane">
			<h3><?php echo __('V2RayQ Lite', 'v2rayq-lite') ?> </h3>
			<p><?php echo __('V2RayQ lite is an automatic V2Ray VMess VPN generator for Wordpress.', 'v2rayq-lite') ?> </p>
			<p><?php echo __('Features:', 'v2rayq-lite') ?></p>
			<p>* <?php echo __('V2Ray + VMess + WebSocket + TLS', 'v2rayq-lite') ?>.</p>
			<p>* <?php echo __('Undetectable VMess protcol', 'v2rayq-lite') ?>.</p>
			<p>* <?php echo __('Input your domain name and then generate V2ray VMess VPN configurations easily', 'v2rayq-lite') ?>.</p>
			<p>* <?php echo __('VMess supports Windows Linux, and Mobile applications such as Shadowrocket and V2ray* applications', 'v2rayq-lite') ?>.</p>
			<p>* <?php echo __('VMess URL and detailed configurations are included', 'v2rayq-lite') ?>.</p> 
			<br>
			<p><?php echo __('Current version', 'v2rayq-lite')?>: 1.1.0</p>
			<p><?php echo __('Documentation', 'v2rayq-lite')?>: <a href="https://www.v2rayq.com/docs/lite"> https://www.v2rayq.com/docs/lite</a></p>
		</div>
	</div>
</div>
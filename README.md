# Settings

Adds a ui interface for modifying canarium core's settings and other settings that customizes the site.

# Installation

Install via composer: 

`composer require unarealidad/canarium-modules-settings dev-master`

Add `Settings` to your Appmaster's `config/application.config.php` or your Appinstance's `config/instance.config.php` under the key `modules`

# Configuration

_None_

# Exposed Pages

URL | Template | Access | Description
----- | ----- | ----- | ----- | -----
   /admin/settings/user | admin/user/index.phtml | Admin | Displays the list of users available in the system
  
\* All template locations are relative to the Appinstance root's /public/templates/settings/. Sample templates are provided in the module's view/ directory.

# Additional Customization

_None_

# Exposed Services
_None_

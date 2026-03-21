# TD8 : Controller JSON et appel AJAX

Nous allons voir comment faire un appel AJAX sur la page produit vers un contrôleur Magento custom.

Commençons par créer un contrôleur AJAX qui va répondre à l'appel JS de la page.

```php
<?php
namespace Univ\Cms\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Ajax extends Action
{
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $data = [
            'success' => true,
            'message' => 'Tout est OK'
        ];

        return $result->setData($data);
    }
}
```

Modifier le bloc plop.html pour lui ajouter un nouveau bloc enfant avec le code suivant :

```html
<h1><?php echo $this->getPlopText(); ?></h1>
<div class="additional-plop-content">
    <?= $block->getChildHtml() ?>
</div>
```

Modifier le layout de la page produit pour inclure le nouveau bloc à l'intérieur du bloc plop.

Ajouter le code suivant dans le template de votre nouveau bloc pour exécuter un script Javascript.

```html
<script>
    require(['jquery'], function ($) {
        $.ajax({
            url: '/plop/index/ajax',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response.message);
            }
        });
    });
</script>
```

Vérifiez dans la console de votre navigateur que le code fonctionne.


## Pour aller plus loin…

> Déclencher l'appel AJAX au clic sur un nouveau bouton "J'aime ce produit"

> Le contrôleur AJAX incrémente un compteur de "Likes" qui est un nouvel attribut `int` sur le produit.

> Ce compteur est affiché à la place du bouton après le clic.
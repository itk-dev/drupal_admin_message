<?php

namespace Drupal\drupal_admin_message\EventSubscriber;

use Drupal\Core\Render\HtmlResponse;
use Drupal\Core\Routing\AdminContext;
use Drupal\Core\Site\Settings;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Response subscriber.
 */
class ResponseSubscriber implements EventSubscriberInterface {
  /**
   * The admin context.
   *
   * @var \Drupal\Core\Routing\AdminContext
   */
  private AdminContext $adminContext;

  /**
   * Constructor.
   */
  public function __construct(AdminContext $adminContext) {
    $this->adminContext = $adminContext;
  }

  /**
   * Response event callback.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The response event.
   */
  public function onResponse(ResponseEvent $event): void {
    $response = $event->getResponse();
    $message = $this->getMessage();

    if (NULL !== $message && $response instanceof HtmlResponse) {
      $content = $response->getContent();
      $content = preg_replace('/<body[^>]*>/', '$0' . $message, $content);

      $response->setContent($content);
    }
  }

  /**
   * Get message.
   */
  private function getMessage(): ?string {
    if ($this->adminContext->isAdminRoute()) {
      $settings = Settings::get('drupal_admin_message');
      $blocks = array_filter((array) ($settings['blocks'] ?? NULL));

      if (!empty($blocks)) {
        $styles = [];
        foreach ((array) ($settings['css'] ?? '') as $name => $value) {
          $styles[] = $name . ': ' . $value;
        }
        return sprintf('<div style="%s%s">%s</div>',
          'padding: 1em; background-color: red; color: yellow; display: flex; justify-content: space-between;',
          implode('; ', $styles),
          implode('', array_map(static fn($block) => '<div>' . $block . '</div>', $blocks))
        );
      }
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => ['onResponse', -1000],
    ];
  }

}

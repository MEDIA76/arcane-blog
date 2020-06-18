<?php

/**
 * Markdown 20.06.2 Arcane Helper
 * MIT https://helpers.arcane.dev
**/

return function($content, $replace = []) {
  if(!is_array($content)) {
    $content = trim($content);

    if(substr($content, -2) === 'md') {
      if(is_file($path = path($content, true))) {
        $content = file_get_contents($path);
      }
    }

    if(!empty($replace)) {
      $content = strtr($content, $replace);
    }

    $content = explode("\n", $content);
  } else {
    if(!empty($replace)) {
      $content = array_map(function($line) use($replace) {
        return strtr($line, $replace);
      }, $content);
    }
  }

  $content = array_values(array_filter($content, 'rtrim'));

  foreach($content as $index => $line) {
    $next = next($content);
    $linestart = ltrim($line)[0] ?? 0;
    $nextstart = ltrim($next)[0] ?? 0;

    unset($format);

    if($linestart === '>') {
      $line = substr($line, strpos($line, '>') + 1);

      if(!isset($quote)) {
        $quote = 'blockquote';
        $results[] = "<{$quote}>";
      }
    }

    if(ctype_space(substr($line, 0, 4))) {
      $line = htmlentities(substr($line, 4));

      if(!isset($code)) {
        $code = 'pre';
        $results[] = "<{$code}><code>";
      } else {
        $format = "\n%s";
      }
    } else {
      preg_match('/^[\s]*(\#{1,6}|\+|\-|\*)\s+(.+)$/', $line, $part);

      if(!empty($part)) {
        $partstart = $part[1];

        if($partstart[0] === '#') {
          $length = strlen($partstart);
          $format = "<h{$length}>%s</h{$length}>";
        } else if(in_array($partstart, ['+', '-', '*'])) {
          $format = "<li>%s</li>";

          if(!isset($primary) || !isset($secondary)) {
            $list = $partstart === '*' ? 'ul' : 'ol';

            if($partstart === '-') {
              $list = "{$list} type=\"A\"";
            }

            if(!isset($primary)) {
              $format = "<{$list}>{$format}";
              $primary = $partstart;
            }

            if(!isset($secondary)) {
              if($linestart !== $primary) {
                $format = "<{$list}>{$format}";
                $secondary = $partstart;
              }
            }
          }

          if(isset($secondary) || isset($primary)) {
            if(trim($next[0]) || !$next) {
              if(isset($secondary)) {
                if($nextstart !== $secondary) {
                  $list = $secondary === '*' ? 'ul' : 'ol';
                  $format = "{$format}</{$list}>";

                  unset($secondary);
                }
              }

              if($nextstart !== $primary) {
                $list = $primary === '*' ? 'ul' : 'ol';
                $format = "{$format}</{$list}>";

                unset($primary);
              }
            }
          }
        }

        $line = $part[2];
      } else {
        $line = ltrim($line);

        if($line === '---') {
          $format = '<hr />';
        } else {
          $format = '<p>%s</p>';
        }
      }

      foreach([
        '*' => '/\*(?! )([^\*]+)(?<! )\*/',
        '_' => '/\_(?! )([^\_]+)(?<! )\_/',
        '~' => '/\~(?! )([^\~]+)(?<! )\~/',
        '`' => '/\`(?! )([^\`]+)(?<! )\`/',
        '![' => '/\!\[(.*)\]\((.*)\)/U',
        '](' => '/\[(.*)\]\((.*)\)/U'
      ] as $search => $regex) {
        if(strpos($line, $search) !== false) {
          if($search === '`') {
            $line = preg_replace_callback($regex, function($match) {
              $match = htmlentities($match[1]);

              return str_replace('$1', $match, '<code>$1</code>');
            }, $line);
          } else {
            $html = [
              '*' => '<strong>$1</strong>',
              '_' => '<em>$1</em>',
              '~' => '<strike>$1</strike>',
              '![' => '<img src="$2" alt="$1" />',
              '](' => '<a href="$2">$1</a>'
            ];

            $line = preg_replace($regex, $html[$search], $line);
          }
        }
      }
    }

    $results[] = sprintf($format ?? "%s", $line);

    if(isset($code)) {
      if(!ctype_space(substr($next, 0, 4))) {
        $results[] = "</{$code}></code>";

        unset($code);
      }
    }

    if(isset($quote)) {
      if($nextstart !== '>') {
        $results[] = "</{$quote}>";

        unset($quote);
      }
    }
  }

  return implode($results);
};

?>
# Video

You can use this view helper to easily display videos in a HTML5 tag. The syntax 
for the view helper is `$this->video($source, $attribs)`, using the
following definitions for the helper arguments:

- `$source`: A string value with the path to a video file or an array 
with different sources
- `$attribs`: An array of html attributes
  
## Basic Usage

The following example shows a simple configuration for only one video file format.

```php
$this->video('/video/file.mp4',
    ['controls' =>
        'loop' => true,
        'width' => '400',
        'height' => '800'
    ]);
```

You should use this example if you want to include different video file formats.

```php
$this->video([
        ['src' => '/video/file.mp4', 'type' => 'video/mp4'],
        ['src' => '/video/file.ogg', 'type' => 'video/ogg']
    ],
        ['controls' =>
            'loop' => true,
            'width' => '400',
            'height' => '800'
        ]);
```
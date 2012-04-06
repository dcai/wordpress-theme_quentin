all:
	cat css/base.css > style.css
	cat css/layout.css >> style.css
	cat css/red.css >> style.css
	yuicompressor style.css -o style.css

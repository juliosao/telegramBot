PROJECT=telegram-bot
DIST=Makefile web
SRCS=$(shell find . -name '*.php')

$(PROJECT).tgz:
	tar cvzf $(PROJECT).tgz $(DIST)

check: $(SRCS)
	rm -f check
	for P in $(SRCS); do php -l $$P >> check; done

.PHONY: clean
clean:
	-rm -f check
	-rm -f $(PROJECT).tgz

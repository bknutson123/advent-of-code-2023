from util import read_file
from numbers import number_lookup


def main():
    input = read_file('input.txt')
    total = 0

    for line_number, line in enumerate(input, start=1):
        first_digit = ''
        last_digit = ''
        digit_word = ''
        for character in line:
            if character.isdigit():
                digit_word = ''
                if not first_digit:
                    first_digit = character
                else:
                    last_digit = character
            else:
                lookup = number_lookup
                for letter in digit_word:
                    lookup = lookup.get(letter)
                lookup = lookup.get(character, None)
                if not lookup:
                    digit_word = character if character in number_lookup else ''
                    continue
                if isinstance(lookup, int):
                    digit_word = character if character in number_lookup else ''
                    if not first_digit:
                        first_digit = lookup
                    else:
                        last_digit = lookup
                else:
                    digit_word += character

        line_total = str(first_digit) + str(last_digit if last_digit else first_digit)
        if line_total:
            total += int(line_total)
    print("Total for all rows: " + str(total))


if __name__ == "__main__":
    main()


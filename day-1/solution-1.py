from util import read_file
import re
def main():
    input = read_file('input.txt')
    total = 0
    for line in input:
        first_digit = re.search(r'\d', line).group()
        last_digit = re.search(r'\d(?=\D*$)', line).group()
        lineTotal = first_digit + last_digit if last_digit else first_digit
        total += int(lineTotal)
        print(lineTotal)
    print("Total for all rows: " + str(total))


if __name__ == "__main__":
    main()

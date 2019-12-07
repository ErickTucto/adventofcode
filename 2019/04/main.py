def check_repeat(number: str) -> bool:
    return [number.count(n) for n in set(number)].count(2) > 0

def is_desc(number: str) -> bool:
    number = [int(n) for n in number]
    return sorted(number) == number


numbers = [x for x in range(125730, 579382)
                        if check_repeat(str(x)) and is_desc(str(x))]

print(len(numbers))
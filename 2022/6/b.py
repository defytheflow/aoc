from pathlib import Path

with open(Path(__file__).parent.joinpath('input.txt')) as f:
    n_unique_characters = 14
    buffer = f.read()
    window = list(buffer[:n_unique_characters])
    for i, char in enumerate(buffer[n_unique_characters:]):
        if len(window) == len(set(window)):
            print(i + n_unique_characters)
            break
        window.pop(0)
        window.append(char)

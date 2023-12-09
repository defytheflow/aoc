import fs from "node:fs";

type Input = Hand[];
type Hand = { cards: CardRank[]; bid: number };
type HandWithType = Hand & { type: HandType };

enum HandType {
  FIVE = "five",
  FOUR = "four",
  FULL_HOUSE = "full house",
  THREE = "three",
  TWO_PAIR = "two pair",
  ONE_PAIR = "one pair",
  HIGH = "high",
}

enum CardRank {
  ACE = "A",
  KING = "K",
  QUEEN = "Q",
  JACK = "J",
  TEN = "T",
  NINE = "9",
  EIGHT = "8",
  SEVEN = "7",
  SIX = "6",
  FIVE = "5",
  FOUR = "4",
  THREE = "3",
  TWO = "2",
}

main();

function main() {
  const input = parseInput("input.txt");

  const resultOne = solveOne(input);
  console.log(resultOne);
  console.assert(resultOne == 250_957_639);

  const resultTwo = solveTwo(input);
  console.log(resultTwo);
  console.assert(resultTwo == Infinity);
}

function solveOne(input: Input): unknown {
  const handTypes = Object.values(HandType);
  const cardRanks = Object.values(CardRank);

  const hands = input;
  const handsWithTypes = hands.map(hand => ({ ...hand, type: calculateHandType(hand) }));
  const sortedHandsWithTypes = handsWithTypes.toSorted(sortHandsByStrength);
  const sortedHandsWithTypesAndRanks = sortedHandsWithTypes.map((hand, index) => ({
    ...hand,
    rank: index + 1,
  }));

  return sortedHandsWithTypesAndRanks.reduce(
    (total, hand) => total + hand.bid * hand.rank,
    0
  );

  function sortHandsByStrength(handA: HandWithType, handB: HandWithType) {
    if (handA.type == handB.type) {
      for (let i = 0; i < handA.cards.length; i++) {
        const cardAIndex = cardRanks.indexOf(handA.cards[i]);
        const cardBIndex = cardRanks.indexOf(handB.cards[i]);
        if (cardAIndex != cardBIndex) {
          return cardBIndex - cardAIndex;
        }
      }
    }

    const handAIndex = handTypes.indexOf(handA.type);
    const handBIndex = handTypes.indexOf(handB.type);

    return handBIndex - handAIndex;
  }

  function calculateHandType(hand: Hand): HandType {
    const countsMap = countByRank(hand);
    const counts = Object.values(countsMap);

    if (counts.includes(5)) return HandType.FIVE;
    if (counts.includes(4)) return HandType.FOUR;
    if (counts.includes(3) && counts.includes(2)) return HandType.FULL_HOUSE;
    if (counts.includes(3)) return HandType.THREE;
    if (counts.filter(n => n == 2).length == 2) return HandType.TWO_PAIR;
    if (counts.filter(n => n == 2).length == 1) return HandType.ONE_PAIR;
    return HandType.HIGH;
  }

  function countByRank(hand: Hand): Record<CardRank, number> {
    return hand.cards.reduce((counts, card) => {
      counts[card] ??= 0;
      counts[card] += 1;
      return counts;
    }, {} as Record<CardRank, number>);
  }
}

function solveTwo(input: Input): unknown {
  console.log(input);
}

function parseInput(filename: string): Input {
  return fs
    .readFileSync(filename)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(line => {
      const [hand, bid] = line.split(" ");
      return { cards: [...hand] as CardRank[], bid: parseInt(bid, 10) };
    });
}

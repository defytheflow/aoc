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
  console.assert(resultTwo == 251_515_496);
}

function solveOne(input: Input): unknown {
  const handTypes = Object.values(HandType);
  const cardRanks = Object.values(CardRank);

  const hands = input;
  const handsWithTypes = hands.map(hand => ({
    ...hand,
    type: determineHandTypeNoJoker(hand),
  }));
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
}

function solveTwo(input: Input): number {
  const handTypes = Object.values(HandType);
  const cardRanks = Object.values(CardRank);

  cardRanks.splice(cardRanks.indexOf(CardRank.JACK), 1);
  cardRanks.push(CardRank.JACK);

  const hands = input;
  const handsWithTypes = hands.map(hand => ({ ...hand, type: determineHandType(hand) }));

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

  function determineHandType(hand: Hand): HandType {
    if (!hand.cards.includes(CardRank.JACK)) {
      return determineHandTypeNoJoker(hand);
    }

    return determineHighestPossibleHandType({
      ...hand,
      type: determineHandTypeNoJoker({
        ...hand,
        cards: hand.cards.filter(card => card != CardRank.JACK),
      }),
    });
  }

  function determineHighestPossibleHandType(hand: HandWithType): HandType {
    const currentHandType = hand.type;
    const numberOfJokers = hand.cards.filter(card => card == CardRank.JACK).length;

    const higherHandTypes = handTypes.slice(0, handTypes.indexOf(currentHandType));
    const availableHigherHandTypes = higherHandTypes.filter(
      higherHandType =>
        numberOfJokersToPromote(currentHandType, higherHandType) <= numberOfJokers
    );

    return availableHigherHandTypes[0] ?? currentHandType;
  }

  function numberOfJokersToPromote(
    currentHandType: HandType,
    desiredHandType: HandType
  ): number {
    switch (currentHandType) {
      case HandType.HIGH:
        switch (desiredHandType) {
          case HandType.ONE_PAIR:
            return 1;
          case HandType.TWO_PAIR:
          case HandType.THREE:
            return 2;
          case HandType.FULL_HOUSE:
          case HandType.FOUR:
            return 3;
          case HandType.FIVE:
            return 4;
          default:
            return 0;
        }
      case HandType.ONE_PAIR:
        switch (desiredHandType) {
          case HandType.TWO_PAIR:
          case HandType.THREE:
            return 1;
          case HandType.FULL_HOUSE:
          case HandType.FOUR:
            return 2;
          case HandType.FIVE:
            return 3;
          default:
            return 0;
        }
      case HandType.TWO_PAIR:
        switch (desiredHandType) {
          case HandType.THREE:
          case HandType.FULL_HOUSE:
            return 1;
          case HandType.FOUR:
            return 2;
          case HandType.FIVE:
            return 3;
          default:
            return 0;
        }
      case HandType.THREE:
        switch (desiredHandType) {
          case HandType.FULL_HOUSE:
          case HandType.FOUR:
            return 1;
          case HandType.FIVE:
            return 2;
          default:
            return 0;
        }
      case HandType.FULL_HOUSE:
        switch (desiredHandType) {
          case HandType.FOUR:
            return 1;
          case HandType.FIVE:
            return 2;
          default:
            return 0;
        }
      case HandType.FOUR:
        switch (desiredHandType) {
          case HandType.FIVE:
            return 1;
          default:
            return 0;
        }
      case HandType.FIVE:
        return 0;
    }
  }
}

function countByRank(hand: Hand): Record<CardRank, number> {
  return hand.cards.reduce((counts, card) => {
    counts[card] ??= 0;
    counts[card] += 1;
    return counts;
  }, {} as Record<CardRank, number>);
}

function determineHandTypeNoJoker(hand: Hand): HandType {
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

function parseInput(filename: string): Input {
  return fs
    .readFileSync(new URL(filename, import.meta.url).pathname)
    .toString()
    .trimEnd()
    .split(/\n|\r\n/)
    .map(line => {
      const [hand, bid] = line.split(" ");
      return { cards: [...hand] as CardRank[], bid: parseInt(bid, 10) };
    });
}

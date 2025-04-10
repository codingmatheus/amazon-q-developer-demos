#include <iostream>
#include <vector>
#include <string>
#include <map>
#include <iomanip>
#include <ctime>
#include <cstdlib>
#include <limits>

// ANSI color codes for red theme
const std::string RED = "\033[1;31m";
const std::string LIGHT_RED = "\033[1;91m";
const std::string DARK_RED = "\033[0;31m";
const std::string RESET = "\033[0m";
const std::string BG_RED = "\033[41m";
const std::string BOLD = "\033[1m";

class Stock {
private:
    std::string symbol;
    std::string name;
    double price;
    double volatility;

public:
    Stock(const std::string& sym, const std::string& n, double p, double vol)
        : symbol(sym), name(n), price(p), volatility(vol) {}

    void updatePrice() {
        // Random price fluctuation based on volatility
        double change = (((double)rand() / RAND_MAX) * 2 - 1) * volatility * price;
        price += change;
        if (price < 0.1) price = 0.1; // Prevent negative or zero prices
    }

    std::string getSymbol() const { return symbol; }
    std::string getName() const { return name; }
    double getPrice() const { return price; }
};

class Portfolio {
private:
    std::map<std::string, int> holdings;
    double cash;

public:
    Portfolio(double initialCash = 10000.0) : cash(initialCash) {}

    bool buyStock(const Stock& stock, int quantity) {
        double cost = stock.getPrice() * quantity;
        if (cost > cash) {
            return false; // Not enough cash
        }
        
        cash -= cost;
        holdings[stock.getSymbol()] += quantity;
        return true;
    }

    bool sellStock(const Stock& stock, int quantity) {
        std::string symbol = stock.getSymbol();
        if (holdings.find(symbol) == holdings.end() || holdings[symbol] < quantity) {
            return false; // Not enough shares
        }
        
        cash += stock.getPrice() * quantity;
        holdings[symbol] -= quantity;
        if (holdings[symbol] == 0) {
            holdings.erase(symbol);
        }
        return true;
    }

    double getCash() const { return cash; }
    
    double getTotalValue(const std::vector<Stock>& stocks) const {
        double total = cash;
        for (const auto& holding : holdings) {
            for (const auto& stock : stocks) {
                if (stock.getSymbol() == holding.first) {
                    total += stock.getPrice() * holding.second;
                    break;
                }
            }
        }
        return total;
    }

    void displayPortfolio(const std::vector<Stock>& stocks) const {
        std::cout << LIGHT_RED << "\n╔════════════════════════════════════════════════════════╗" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << BOLD << "YOUR PORTFOLIO" << LIGHT_RED << "                                     ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "Cash: $" << std::fixed << std::setprecision(2) << cash << std::setw(47 - std::to_string((int)cash).length()) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        
        if (holdings.empty()) {
            std::cout << LIGHT_RED << "║ " << RESET << "No stocks owned" << std::setw(38) << LIGHT_RED << " ║" << RESET << std::endl;
        } else {
            std::cout << LIGHT_RED << "║ " << BOLD << "Symbol  Quantity  Price      Value" << std::setw(17) << LIGHT_RED << " ║" << RESET << std::endl;
            std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
            
            for (const auto& holding : holdings) {
                for (const auto& stock : stocks) {
                    if (stock.getSymbol() == holding.first) {
                        double value = stock.getPrice() * holding.second;
                        std::cout << LIGHT_RED << "║ " << RESET 
                                  << std::left << std::setw(8) << holding.first 
                                  << std::setw(10) << holding.second 
                                  << "$" << std::fixed << std::setprecision(2) << std::setw(10) << stock.getPrice() 
                                  << "$" << std::setw(10) << value 
                                  << LIGHT_RED << " ║" << RESET << std::endl;
                        break;
                    }
                }
            }
        }
        
        double totalValue = getTotalValue(stocks);
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << BOLD << "Total Portfolio Value: $" << std::fixed << std::setprecision(2) << totalValue << std::setw(25 - std::to_string((int)totalValue).length()) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╚════════════════════════════════════════════════════════╝" << RESET << std::endl;
    }
};

class StockExchange {
private:
    std::vector<Stock> stocks;
    Portfolio userPortfolio;
    int day;

    void displayHeader() {
        std::cout << "\033[2J\033[1;1H"; // Clear screen
        std::cout << BG_RED << BOLD << "                                                          " << RESET << std::endl;
        std::cout << BG_RED << BOLD << "                  RED BULL STOCK EXCHANGE                 " << RESET << std::endl;
        std::cout << BG_RED << BOLD << "                                                          " << RESET << std::endl;
        std::cout << LIGHT_RED << "╔════════════════════════════════════════════════════════╗" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "Day: " << day << std::setw(50 - std::to_string(day).length()) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╚════════════════════════════════════════════════════════╝" << RESET << std::endl;
    }

    void displayStocks() {
        std::cout << LIGHT_RED << "\n╔════════════════════════════════════════════════════════╗" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << BOLD << "AVAILABLE STOCKS" << LIGHT_RED << "                                    ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << BOLD << "ID  Symbol  Name                  Price" << std::setw(14) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        
        for (size_t i = 0; i < stocks.size(); ++i) {
            std::cout << LIGHT_RED << "║ " << RESET 
                      << std::left << std::setw(4) << i + 1 
                      << std::setw(8) << stocks[i].getSymbol() 
                      << std::setw(23) << stocks[i].getName() 
                      << "$" << std::fixed << std::setprecision(2) << std::setw(10) << stocks[i].getPrice() 
                      << LIGHT_RED << " ║" << RESET << std::endl;
        }
        
        std::cout << LIGHT_RED << "╚════════════════════════════════════════════════════════╝" << RESET << std::endl;
    }

    void displayMenu() {
        std::cout << LIGHT_RED << "\n╔════════════════════════════════════════════════════════╗" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << BOLD << "MENU OPTIONS" << LIGHT_RED << "                                       ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╠════════════════════════════════════════════════════════╣" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "1. Buy Stocks" << std::setw(40) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "2. Sell Stocks" << std::setw(39) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "3. View Portfolio" << std::setw(36) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "4. Advance to Next Day" << std::setw(31) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "║ " << RESET << "5. Exit" << std::setw(45) << LIGHT_RED << " ║" << RESET << std::endl;
        std::cout << LIGHT_RED << "╚════════════════════════════════════════════════════════╝" << RESET << std::endl;
        std::cout << RED << "\nEnter your choice: " << RESET;
    }

    void buyStocks() {
        displayStocks();
        int stockId, quantity;
        
        std::cout << RED << "\nEnter stock ID to buy (0 to cancel): " << RESET;
        std::cin >> stockId;
        
        if (stockId <= 0 || stockId > static_cast<int>(stocks.size())) {
            if (stockId != 0) {
                std::cout << RED << "Invalid stock ID!" << RESET << std::endl;
                std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
                std::cout << "\nPress Enter to continue...";
                std::cin.get();
            }
            return;
        }
        
        std::cout << RED << "Enter quantity to buy: " << RESET;
        std::cin >> quantity;
        
        if (quantity <= 0) {
            std::cout << RED << "Invalid quantity!" << RESET << std::endl;
            std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
            std::cout << "\nPress Enter to continue...";
            std::cin.get();
            return;
        }
        
        bool success = userPortfolio.buyStock(stocks[stockId - 1], quantity);
        
        if (success) {
            std::cout << LIGHT_RED << "\n✓ Successfully bought " << quantity << " shares of " 
                      << stocks[stockId - 1].getSymbol() << " for $" 
                      << std::fixed << std::setprecision(2) << (stocks[stockId - 1].getPrice() * quantity) 
                      << RESET << std::endl;
        } else {
            std::cout << RED << "\n✗ Not enough cash to complete this transaction!" << RESET << std::endl;
        }
        
        std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
        std::cout << "\nPress Enter to continue...";
        std::cin.get();
    }

    void sellStocks() {
        userPortfolio.displayPortfolio(stocks);
        displayStocks();
        
        int stockId, quantity;
        
        std::cout << RED << "\nEnter stock ID to sell (0 to cancel): " << RESET;
        std::cin >> stockId;
        
        if (stockId <= 0 || stockId > static_cast<int>(stocks.size())) {
            if (stockId != 0) {
                std::cout << RED << "Invalid stock ID!" << RESET << std::endl;
                std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
                std::cout << "\nPress Enter to continue...";
                std::cin.get();
            }
            return;
        }
        
        std::cout << RED << "Enter quantity to sell: " << RESET;
        std::cin >> quantity;
        
        if (quantity <= 0) {
            std::cout << RED << "Invalid quantity!" << RESET << std::endl;
            std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
            std::cout << "\nPress Enter to continue...";
            std::cin.get();
            return;
        }
        
        bool success = userPortfolio.sellStock(stocks[stockId - 1], quantity);
        
        if (success) {
            std::cout << LIGHT_RED << "\n✓ Successfully sold " << quantity << " shares of " 
                      << stocks[stockId - 1].getSymbol() << " for $" 
                      << std::fixed << std::setprecision(2) << (stocks[stockId - 1].getPrice() * quantity) 
                      << RESET << std::endl;
        } else {
            std::cout << RED << "\n✗ You don't own enough shares to complete this transaction!" << RESET << std::endl;
        }
        
        std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
        std::cout << "\nPress Enter to continue...";
        std::cin.get();
    }

    void advanceDay() {
        day++;
        
        // Update all stock prices
        for (auto& stock : stocks) {
            stock.updatePrice();
        }
        
        std::cout << LIGHT_RED << "\n→ Advanced to Day " << day << RESET << std::endl;
        std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
        std::cout << "\nPress Enter to continue...";
        std::cin.get();
    }

public:
    StockExchange() : day(1) {
        // Initialize with some stocks
        stocks.push_back(Stock("AAPL", "Apple Inc.", 150.75, 0.03));
        stocks.push_back(Stock("MSFT", "Microsoft Corp.", 290.20, 0.025));
        stocks.push_back(Stock("AMZN", "Amazon.com Inc.", 3200.50, 0.04));
        stocks.push_back(Stock("GOOGL", "Alphabet Inc.", 2800.30, 0.035));
        stocks.push_back(Stock("TSLA", "Tesla Inc.", 750.80, 0.06));
        stocks.push_back(Stock("FB", "Meta Platforms Inc.", 330.25, 0.045));
        stocks.push_back(Stock("NFLX", "Netflix Inc.", 550.40, 0.05));
        stocks.push_back(Stock("NVDA", "NVIDIA Corp.", 220.75, 0.055));
        
        // Seed random number generator
        srand(static_cast<unsigned int>(time(nullptr)));
    }

    void run() {
        int choice;
        bool running = true;
        
        while (running) {
            displayHeader();
            displayStocks();
            displayMenu();
            
            std::cin >> choice;
            std::cin.ignore(std::numeric_limits<std::streamsize>::max(), '\n');
            
            switch (choice) {
                case 1:
                    buyStocks();
                    break;
                case 2:
                    sellStocks();
                    break;
                case 3:
                    userPortfolio.displayPortfolio(stocks);
                    std::cout << "\nPress Enter to continue...";
                    std::cin.get();
                    break;
                case 4:
                    advanceDay();
                    break;
                case 5:
                    running = false;
                    break;
                default:
                    std::cout << RED << "Invalid choice! Please try again." << RESET << std::endl;
                    std::cout << "\nPress Enter to continue...";
                    std::cin.get();
            }
        }
        
        // Display final portfolio value
        std::cout << "\033[2J\033[1;1H"; // Clear screen
        std::cout << BG_RED << BOLD << "                                                          " << RESET << std::endl;
        std::cout << BG_RED << BOLD << "                  SESSION SUMMARY                         " << RESET << std::endl;
        std::cout << BG_RED << BOLD << "                                                          " << RESET << std::endl;
        
        userPortfolio.displayPortfolio(stocks);
        
        std::cout << LIGHT_RED << "\nThank you for using Red Bull Stock Exchange!" << RESET << std::endl;
        std::cout << LIGHT_RED << "Final day: " << day << RESET << std::endl;
    }
};

int main() {
    StockExchange exchange;
    exchange.run();
    return 0;
}

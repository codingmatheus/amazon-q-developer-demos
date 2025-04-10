#!/usr/bin/env python3
"""
Refactored Calculator App using higher-order functions
"""

from functools import partial

def safe_operation(operation_func, a, b, error_value=None):
    """
    Higher-order function that safely executes an operation and handles exceptions.
    
    Args:
        operation_func: The operation function to execute
        a: First operand
        b: Second operand
        error_value: Value to return if operation fails
        
    Returns:
        Result of operation or error_value if operation fails
    """
    try:
        return operation_func(a, b)
    except Exception:
        return error_value

# Basic operations as pure functions
def add(a, b):
    return a + b

def subtract(a, b):
    return a - b

def multiply(a, b):
    return a * b

def divide(a, b):
    if b == 0:
        raise ZeroDivisionError("Cannot divide by zero")
    return a / b

def power(a, b):
    return a ** b

# Dictionary of operations using higher-order functions
operations = {
    '1': {
        'name': 'Add',
        'symbol': '+',
        'func': partial(safe_operation, add, error_value="Error")
    },
    '2': {
        'name': 'Subtract',
        'symbol': '-',
        'func': partial(safe_operation, subtract, error_value="Error")
    },
    '3': {
        'name': 'Multiply',
        'symbol': '*',
        'func': partial(safe_operation, multiply, error_value="Error")
    },
    '4': {
        'name': 'Divide',
        'symbol': '/',
        'func': partial(safe_operation, divide, error_value="Cannot divide by zero")
    },
    '5': {
        'name': 'Power',
        'symbol': '^',
        'func': partial(safe_operation, power, error_value="Error in calculation")
    }
}

def main():
    print("Welcome to the Refactored Calculator App")
    print("=======================================")
    
    while True:
        print("\nOperations:")
        for key, op in operations.items():
            print(f"{key}. {op['name']}")
        print("6. Exit")
        
        choice = input("\nEnter your choice (1-6): ")
        
        if choice == '6':
            print("Thank you for using the calculator. Goodbye!")
            break
        
        if choice not in operations:
            print("Invalid choice. Please try again.")
            continue
        
        try:
            num1 = float(input("Enter first number: "))
            num2 = float(input("Enter second number: "))
            
            operation = operations[choice]
            result = operation['func'](num1, num2)
            
            print(f"Result: {num1} {operation['symbol']} {num2} = {result}")
            
        except ValueError:
            print("Error: Please enter valid numbers.")
        
if __name__ == "__main__":
    main()

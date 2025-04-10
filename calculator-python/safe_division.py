def safe_divide(numerator, denominator, default_value=None):
    """
    Safely divide two numbers by handling division by zero.
    
    Args:
        numerator: The number to be divided
        denominator: The number to divide by
        default_value: The value to return if denominator is zero (default: None)
        
    Returns:
        The result of division or the default_value if denominator is zero
    """
    try:
        if denominator == 0:
            return default_value
        return numerator / denominator
    except ZeroDivisionError:
        return default_value

# Example usage
if __name__ == "__main__":
    # These will work safely
    print(f"10/2 = {safe_divide(10, 2)}")           # Returns 5.0
    print(f"10/0 = {safe_divide(10, 0)}")           # Returns None
    print(f"10/0 = {safe_divide(10, 0, 'Error')}")  # Returns 'Error'
    print(f"10/0 = {safe_divide(10, 0, 0)}")        # Returns 0
